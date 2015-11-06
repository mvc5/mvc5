<?php
/**
 *
 */

namespace Mvc5\Service\Resolver;

use Closure;
use InvalidArgumentException;
use Mvc5\Config\Configuration;
use Mvc5\Event\Event;
use Mvc5\Service\Config\Args\Arguments;
use Mvc5\Service\Config\Call\ServiceCall;
use Mvc5\Service\Config\Calls\ServiceCalls;
use Mvc5\Service\Config\Child\ChildService;
use Mvc5\Service\Config\ConfigLink\ConfigServiceLink;
use Mvc5\Service\Config\Configuration as Config;
use Mvc5\Service\Config\Dependency\ServiceDependency;
use Mvc5\Service\Config\Factory\ServiceFactory;
use Mvc5\Service\Config\Filter\ServiceFilter;
use Mvc5\Service\Config\Invokable\ServiceInvokable;
use Mvc5\Service\Config\Invoke\ServiceInvoke;
use Mvc5\Service\Config\Param\ServiceParam;
use Mvc5\Service\Config\ServiceConfig\ServiceConfiguration;
use Mvc5\Service\Config\ServiceManagerLink\ServiceManager as ServiceManagerLink;
use Mvc5\Service\Container\ServiceCollection;
use Mvc5\Service\Manager\ServiceManager;
use ReflectionClass;
use RuntimeException;

trait Resolver
{
    /**
     *
     */
    use Signal;

    /**
     * @param $args
     * @return array|callable|null|object|string
     */
    protected function args($args)
    {
        if (!$args) {
            return $args;
        }

        if (!is_array($args)) {
            return $this->resolve($args);
        }

        foreach($args as $index => $value) {
            $value instanceof Resolvable && $args[$index] = $this->resolve($value);
        }

        return $args;
    }

    /**
     * @param array $config
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function build(array $config, array $args = [], callable $callback = null)
    {
        if (!isset($config[1])) {
            return $callback && !class_exists($config[0]) ?
                $callback($config[0]) : $this->make($config[0], $args, $callback);
        }

        return $this->compose($this->create(array_shift($config), $args, $callback), $config, $args, $callback);
    }

    /**
     * @param array|callable|object|string $config
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     * @throws RuntimeException
     */
    public function call($config, array $args = [], callable $callback = null)
    {
        if (!is_string($config)) {
            return $config instanceof Event ? $this->trigger($config, $args, $callback ?: $this)
                : $this->invoke($config, $args, $callback);
        }

        $config = explode(Args::CALL_SEPARATOR, $config);
        $plugin = array_shift($config);
        $method = array_pop($config);

        $plugin = $this->plugin($plugin, [], function($plugin) {
            if (!is_callable($plugin)) {
                if ($event = $this->call(Args::EVENT_CREATE, [Args::SERVICE => $plugin])) {
                    return $event;
                }

                throw new RuntimeException('Plugin is not callable: ' . $plugin);
            }

            return $plugin;
        });

        if ($plugin instanceof Event) {
            return $this->trigger($plugin, $args, $callback ?: $this);
        }

        foreach($config as $name) {
            $plugin = $this->invoke([$plugin, $name], $args, $callback);
        }

        return $this->invoke($method ? [$plugin, $method] : $plugin, $args, $callback);
    }

    /**
     * @param callable $callback
     * @return callable
     */
    protected function callback($callback)
    {
        if (!is_callable($callback)) {
            throw new InvalidArgumentException('Invalid callback');
        }

        return $callback;
    }

    /**
     * @param ChildService $config
     * @param array $args
     * @return array|callable|object|string
     */
    protected function child(ChildService $config, array $args = [])
    {
        return $this->provide($this->merge(clone $this->configured($this->resolve($config->parent())), $config), $args);
    }

    /**
     * @param mixed $service
     * @param array $config
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function compose($service, array $config, array $args = [], callable $callback = null)
    {
        foreach($config as $name) {
            $service = $service instanceof ServiceManager ? $service->create($name, $args, $callback) : (
                $service instanceof ServiceCollection ? $this->create($service[$name], $args, $callback) :
                    $this->resolve($service[$name], $args)
            );
        }

        return $service;
    }

    /**
     * @return Configuration
     */
    public abstract function config();

    /**
     * @param string $name
     * @return array|callable|Config|null|object|string
     */
    public abstract function configured($name);

    /**
     * @param array|callable|Config|object|string $config
     * @param array $args
     * @param callable $callback
     * @return callable|null|object
     */
    protected abstract function create($config, array $args = [], callable $callback = null);

    /**
     * @param array|callable|null|object|string $arg
     * @param array $filters
     * @return mixed
     */
    protected function filter($arg, array $filters)
    {
        foreach($filters as $filter) {
            $arg = $filter($arg);
        }

        return $arg;
    }

    /**
     * @param string $name
     * @return null|object|callable
     */
    public abstract function get($name);

    /**
     * @param Config $config
     * @param object $service
     * @return object
     */
    protected function hydrate(Config $config, $service)
    {
        foreach($config->calls() as $method => $args) {
            if (is_string($method)) {
                if (Args::INDEX == $method[0]) {
                    $service[substr($method, 1)] = $this->resolve($args);
                    continue;
                }

                if (Args::PROPERTY == $method[0]) {
                    $service->{substr($method, 1)} = $this->resolve($args);
                    continue;
                }

                $service->$method($this->resolve($args));
                continue;
            }

            if (is_array($args)) {
                $method = array_shift($args);
                $param  = $config->param();

                if (is_string($method) && Args::PROPERTY == $method[0]) {
                    $param  = substr($method, 1);
                    $method = array_shift($args);
                }

                $this->invoke(
                    is_string($method) ? [$service, $method] : $method,
                    $param && (!$args || is_string(key($args))) ? [$param => $service] + $args : $args
                );

                continue;
            }

            $this->resolve($args);
        }

        return $service;
    }

    /**
     * @param array|callable|object|string $config
     * @return callable|null
     */
    protected function invokable($config)
    {
        if (is_string($config) && Args::CALL === $config[0]) {
            return function($args = []) use ($config) {
                return $this->call(
                    substr($config, 1),
                    !is_array($args) || !is_string(key($args)) ? func_get_args() : $args
                );
            };
        }

        if (is_array($config)) {
            return $this->callback(is_string($config[0]) ? $config : [$this->create($config[0]), $config[1]]);
        }

        return $config instanceof Closure ? $config : $this->callback($this->create($config));
    }

    /**
     * @param array|callable|object|string $config
     * @param array $args
     * @param callable $callback
     * @return array|callable|object|string
     */
    protected function invoke($config, array $args = [], callable $callback = null)
    {
        return $this->signal($this->callback($this->args($config)), $this->args($args), $callback ?: $this);
    }

    /**
     * @param string $name
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function make($name, array $args = [], callable $callback = null)
    {
        $class = new ReflectionClass($name);

        if (!$class->hasMethod('__construct')) {
            return $class->newInstanceWithoutConstructor();
        }

        if ($args && !is_string(key($args))) {
            return $class->newInstanceArgs($this->args($args));
        }

        $matched = [];
        $params  = $class->getConstructor()->getParameters();

        foreach($params as $param) {
            if (isset($args[$param->name])) {
                $matched[] = $this->resolve($args[$param->name]);
                continue;
            }

            if ($param->isOptional()) {
                $matched[] = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null;
                continue;
            }

            if ($hint = $param->getClass()) {
                $matched[] = $this->create($hint->name);
                continue;
            }

            if ($callback && null !== $match = $callback($param->name)) {
                $matched[] = $match;
                continue;
            }

            throw new RuntimeException('Missing required parameter $' . $param->name . ' for ' . $name);
        }

        return $class->newInstanceArgs($params ? $matched : $this->args($args));
    }

    /**
     * @param Config $parent
     * @param Config $config
     * @return Config
     */
    protected function merge(Config $parent, Config $config)
    {
        !$parent->name() && $parent->set(Config::NAME, $this->resolve($config->name()));

        $config->args() && $parent->set(
            Config::ARGS,
            is_string(key($config->args())) ? $config->args() + $parent->args() : $config->args()
        );

        $config->calls() && $parent->set(
            Config::CALLS,
            $config->merge() ? array_merge($parent->calls(), $config->calls()) : $config->calls()
        );

        return $parent;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function param($name)
    {
        $name  = explode(Args::CALL_SEPARATOR, $name);
        $value = $this->config()[array_shift($name)];

        foreach($name as $n) {
            $value = $value[$n];
        }

        return $value;
    }

    /**
     * @param string $name
     * @param callable $callback
     * @param array $args
     * @return callable|null|object
     */
    protected abstract function plugin($name, array $args = [], callable $callback = null);

    /**
     * @param Config $config
     * @param array $args
     * @return callable|null|object
     */
    protected function provide(Config $config, array $args = [])
    {
        $name   = $this->solve($config->name());
        $parent = $this->configured($name);

        $args && is_string(key($args)) && $config->args() && $args += $config->args();

        !$args && $args = $config->args();

        if ($parent && !$parent instanceof Config) {
            return $this->hydrate($config, $this->create($this->solve($parent), $args));
        }

        if (!$parent || $name == $parent->name()) {
            return $this->hydrate($config, $this->build(explode(Args::SERVICE_SEPARATOR, $name), $args));
        }

        return $this->provide($this->merge(clone $parent, $config), $args);
    }

    /**
     * @param $config
     * @param array $args
     * @return array|callable|null|object|string
     */
    protected function resolve($config, array $args = [])
    {
        if (!$config instanceof Resolvable) {
            return $config;
        }

        if ($config instanceof ServiceFactory) {
            return $this->invoke($this->child($config, $args));
        }

        if ($config instanceof ServiceCalls) {
            return $this->hydrate($config, $this->resolve($config->name(), $args));
        }

        if ($config instanceof ChildService) {
            return $this->child($config, $args);
        }

        if ($config instanceof Config) {
            return $this->provide($config, $args);
        }

        if ($config instanceof ServiceDependency) {
            return $this->get($config->name());
        }

        if ($config instanceof ServiceParam) {
            return $this->resolve($this->param($config->name()));
        }

        if ($config instanceof ServiceCall) {
            return $this->call($config->config(), $config->args());
        }

        if ($config instanceof Arguments) {
            return $this->args($config->config());
        }

        if ($config instanceof ConfigServiceLink) {
            return $this->config();
        }

        if ($config instanceof ServiceManagerLink) {
            return $this;
        }

        if ($config instanceof ServiceFilter) {
            return $this->filter($this->resolve($config->config()), $config->filter());
        }

        if ($config instanceof ServiceConfiguration) {
            return $this->configured($config->name());
        }

        if ($config instanceof ServiceInvoke) {
            return function(array $args = []) use ($config) {
                return $this->call($config->config(), $config->args() + $args);
            };
        }

        if ($config instanceof ServiceInvokable) {
            return function() use ($config) {
                return $this->solve($config->config());
            };
        }

        return $this->call(Args::PROVIDER, [Args::SERVICE => $config]);
    }

    /**
     * @param $config
     * @return mixed
     */
    protected function solve($config)
    {
        return $config instanceof Resolvable ? $this->solve($this->resolve($config)) : $config;
    }

    /**
     * @param array|Event|string $event
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    protected abstract function trigger($event, array $args = [], callable $callback = null);

    /**
     * @param string $name
     * @param callable $callback
     * @param array $args
     * @return array|callable|null|object|string
     */
    public function __invoke($name, array $args = [], callable $callback = null)
    {
        return $this->plugin($name, $args, $callback);
    }
}
