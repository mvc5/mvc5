<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Closure;
use Mvc5\Arg;
use Mvc5\Event\Event;
use Mvc5\Plugin\Gem\Args;
use Mvc5\Plugin\Gem\Call;
use Mvc5\Plugin\Gem\Calls;
use Mvc5\Plugin\Gem\Child;
use Mvc5\Plugin\Gem\Config;
use Mvc5\Plugin\Gem\Dependency;
use Mvc5\Plugin\Gem\Factory;
use Mvc5\Plugin\Gem\Filter;
use Mvc5\Plugin\Gem\Invokable;
use Mvc5\Plugin\Gem\Invoke;
use Mvc5\Plugin\Gem\Link;
use Mvc5\Plugin\Gem\Param;
use Mvc5\Plugin\Gem\Plug;
use Mvc5\Plugin\Gem\Plugin;
use Mvc5\Resolvable;
use Mvc5\Service\Config as Container;
use Mvc5\Service\Container as ServiceContainer;
use Mvc5\Service\Manager as ServiceManager;
use Mvc5\Signal;
use ReflectionClass;
use RuntimeException;

trait Resolver
{
    /**
     *
     */
    use Alias;
    use Container;
    use Initializer;
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
            return $config instanceof Event ? $this->generate($config, $args, $callback ?? $this) :
                $this->invoke($config, $args, $callback);
        }

        $config = explode(Arg::CALL_SEPARATOR, $config);
        $name   = array_shift($config);
        $method = array_pop($config);

        $plugin = $this->plugin($name, [], function($name) {
            return is_callable($name) ? $name : $this->call(Arg::SERVICE_LOCATOR, [Arg::NAME => $name]);
        });

        if ($plugin instanceof Event) {
            return $this->generate($plugin, $args, $callback ?? $this);
        }

        foreach($config as $name) {
            $plugin = $this->invoke([$plugin, $name], $args, $callback);
        }

        return $this->invoke($method ? [$plugin, $method] : $plugin, $args, $callback);
    }

    /**
     * @param Child $config
     * @param array $args
     * @return array|callable|object|string
     */
    protected function child(Child $config, array $args = [])
    {
        return $this->provide($this->merge(clone $this->parent($config->parent()), $config), $args);
    }

    /**
     * @param $plugin
     * @param array $config
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function compose($plugin, array $config = [], array $args = [], callable $callback = null)
    {
        foreach($config as $name) {
            $plugin = $plugin instanceof ServiceManager ? $plugin->plugin($name, $args, $callback) : (
                $plugin instanceof ServiceContainer ? $this->plugin($plugin[$name], $args, $callback) :
                    $this->resolve($plugin[$name], $args)
            );
        }

        return $plugin;
    }

    /**
     * @param $name
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function create($name, array $args = [], callable $callback = null)
    {
        return $this->plugin($this->configured($name), $args) ?? (
            $callback && !class_exists($name) ? $callback($name) : $this->make($name, $args)
        );
    }

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
     * @param array|object|string|\Traversable $event
     * @param array $args
     * @param callable $callback
     * @return mixed|null
     */
    protected abstract function generate($event, array $args = [], callable $callback = null);

    /**
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->shared($name) ?? $this->plugin($name);
    }

    /**
     * @param Plugin $config
     * @param object $service
     * @return object
     */
    protected function hydrate(Plugin $config, $service)
    {
        foreach($config->calls() as $method => $args) {
            if (is_string($method)) {
                if (Arg::INDEX == $method[0]) {
                    $service[substr($method, 1)] = $this->resolve($args);
                    continue;
                }

                if (Arg::PROPERTY == $method[0]) {
                    $service->{substr($method, 1)} = $this->resolve($args);
                    continue;
                }

                $service->$method($this->resolve($args));
                continue;
            }

            if (is_array($args)) {
                $method = array_shift($args);
                $param  = $config->param();

                if (is_string($method) && Arg::PROPERTY == $method[0]) {
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
    protected function invokable($config) : callable
    {
        if (is_string($config)) {
            return Arg::CALL === $config[0] ? substr($config, 1) :
                $this->listener($this->plugin($config, [], function($name) { return $name; }));
        }

        if (is_array($config)) {
            return is_string($config[0]) ? $config : [$this->plugin($config[0]), $config[1]];
        }

        return $config instanceof Closure ? $config : $this->listener($this->plugin($config));
    }

    /**
     * @param array|callable|object|string $config
     * @param array $args
     * @param callable $callback
     * @return array|callable|object|string
     */
    protected function invoke($config, array $args = [], callable $callback = null)
    {
        return $this->signal($this->args($config), $this->args($args), $callback ?? $this);
    }

    /**
     * @param array|callable|object|string $config
     * @return callable|null
     */
    protected function listener($config)
    {
        return !$config instanceof Event ? $config : (
            function(array $args = []) use ($config) { return $this->call($config, $args); }
        );
    }

    /**
     * @param string $name
     * @param array $args
     * @return callable|object
     */
    protected function make($name, array $args = [])
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

            if (null !== ($hint = $param->getClass()) && null !== $match = $this($hint->name)) {
                $matched[] = $match;
                continue;
            }

            if (null !== $match = $this($param->name)) {
                $matched[] = $match;
                continue;
            }

            throw new RuntimeException('Missing required parameter $' . $param->name . ' for ' . $name);
        }

        return $class->newInstanceArgs($params ? $matched : $this->args($args));
    }

    /**
     * @param Plugin $parent
     * @param Plugin $config
     * @return Plugin
     */
    protected function merge(Plugin $parent, Plugin $config)
    {
        !$parent->name() && $parent->set(Arg::NAME, $this->resolve($config->name()));

        $config->args() && $parent->set(
            Arg::ARGS,
            is_string(key($config->args())) ? $config->args() + $parent->args() : $config->args()
        );

        $config->calls() && $parent->set(
            Arg::CALLS,
            $config->merge() ? array_merge($parent->calls(), $config->calls()) : $config->calls()
        );

        $config->param() && $parent->set(Arg::PARAM, $config->param());

        return $parent;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function param($name)
    {
        $name  = explode(Arg::CALL_SEPARATOR, $name);
        $value = $this->config()[array_shift($name)];

        foreach($name as $n) {
            $value = $value[$n];
        }

        return $value;
    }

    /**
     * @param $config
     * @return array|callable|Plugin|null|object|string
     */
    protected function parent($config)
    {
        return $this->configured($this->resolve($config));
    }

    /**
     * @param string $config
     * @param array $args
     * @param callable|null $callback
     * @return array|callable|null|object|string
     */
    public function plugin($config, array $args = [], callable $callback = null)
    {
        if (!$config) {
            return $config;
        }

        if (is_string($config)) {
            return $this->resolve($this->alias($config), $args) ??
                $this->build(explode(Arg::SERVICE_SEPARATOR, $config), $args, $callback);
        }

        if (is_array($config)) {
            return $this->plugin(array_shift($config), $args + $config, $callback);
        }

        if ($config instanceof Closure) {
            return $this->invoke($config, $args, $callback);
        }

        return $this->resolve($config, $args);
    }

    /**
     * @param Plugin $config
     * @param array $args
     * @return callable|null|object
     */
    protected function provide(Plugin $config, array $args = [])
    {
        $name   = $this->solve($config->name());
        $parent = $this->configured($name);

        $args && is_string(key($args)) && $config->args() && $args += $config->args();

        !$args && $args = $config->args();

        if ($parent && !$parent instanceof Plugin) {
            return $this->hydrate($config, $this->plugin($this->solve($parent), $args));
        }

        if (!$parent || $name == $parent->name()) {
            return $this->hydrate($config, $this->build(explode(Arg::SERVICE_SEPARATOR, $name), $args));
        }

        return $this->provide($this->merge(clone $parent, $config), $args);
    }

    /**
     * @param $config
     * @param array $args
     * @return array|callable|Plugin|null|object|Resolvable|string
     */
    protected function resolve($config, array $args = [])
    {
        if (!$config instanceof Resolvable) {
            return $config;
        }

        if ($config instanceof Factory) {
            return $this->invoke($this->child($config, $args));
        }

        if ($config instanceof Calls) {
            return $this->hydrate($config, $this->resolve($config->name(), $args));
        }

        if ($config instanceof Child) {
            return $this->child($config, $args);
        }

        if ($config instanceof Plugin) {
            return $this->provide($config, $args);
        }

        if ($config instanceof Dependency) {
            return $this->shared($config->name()) ?? $this->initialize($config->name(), $config->config());
        }

        if ($config instanceof Param) {
            return $this->resolve($this->param($config->name()), $args);
        }

        if ($config instanceof Call) {
            return $this->call($config->config(), $args + $config->args());
        }

        if ($config instanceof Args) {
            return $this->args($config->config());
        }

        if ($config instanceof Config) {
            return $this->config();
        }

        if ($config instanceof Link) {
            return $this;
        }

        if ($config instanceof Filter) {
            return $this->filter($this->resolve($config->config()), $config->filter());
        }

        if ($config instanceof Plug) {
            return is_string($config->name()) ? $this->configured($config->name()) : $config->name();
        }

        if ($config instanceof Invoke) {
            return function(array $args = []) use ($config) {
                return $this->call($this->solve($config->config()), $args + $this->args($config->args()));
            };
        }

        if ($config instanceof Invokable) {
            return function(array $args = []) use ($config) {
                return $this->solve($this->resolve($config->config(), $args + $config->args()));
            };
        }

        return $this->call(Arg::SERVICE_RESOLVER, [Arg::PLUGIN => $config]);
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
     * @param array|object|string|\Traversable $event
     * @param array $args
     * @param callable $callback
     * @return mixed|null
     */
    public function trigger($event, array $args = [], callable $callback = null)
    {
        return $this->generate(
            $event instanceof Event ? $event : $this->plugin($event) ?? $event, $args, $callback ?? $this
        );
    }

    /**
     * @param string $name
     * @param callable $callback
     * @param array $args
     * @return array|callable|null|object|string
     */
    public function __invoke($name, array $args = [], callable $callback = null)
    {
        return $this->plugin($name, $args, $callback ?? function(){});
    }
}
