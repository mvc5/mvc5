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
use Mvc5\Service\Config as Container;
use Mvc5\Service\Container as ServiceContainer;
use Mvc5\Service\Manager as ServiceManager;
use Mvc5\Resolvable;
use ReflectionClass;
use RuntimeException;

trait Resolver
{
    /**
     *
     */
    use Container;
    use Generator;
    use Initializer;

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
     * @param bool $plugin
     * @return callable|object
     */
    protected function build(array $config, array $args = [], callable $callback = null, $plugin = false)
    {
        return $this->combine(array_shift($config), $config, $args, $callback, $plugin);
    }

    /**
     * @param array|callable|object|string $config
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     * @throws \RuntimeException
     */
    public function call($config, array $args = [], callable $callback = null)
    {
        if (is_string($config)) {
            return $this->transmit(explode(Arg::CALL_SEPARATOR, $config), $args, $callback);
        }

        if ($config instanceof Event) {
            return $this->event($config, $args, $callback);
        }

        return $this->invoke($config, $args, $callback);
    }

    /**
     * @param array|callable|object|string $config
     * @return callable|null
     */
    protected function callable($config) : callable
    {
        if (is_string($config)) {
            return function($args = []) use($config) { return $this->call($config, $args); };
        }

        if (is_array($config)) {
            return is_string($config[0]) ? $config : [$this->resolve($config[0]), $config[1]];
        }

        return $config instanceof Closure ? $config : $this->listener($this->resolve($config));
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
     * @param $name
     * @param array $config
     * @param array $args
     * @param callable $callback
     * @param bool $plugin
     * @return callable|object
     */
    protected function combine($name, array $config, array $args = [], callable $callback = null, $plugin = false)
    {
        return $this->compose(
            $this->create($name, $args, $callback, $plugin || $config), $config, $args, $callback
        );
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
     * @param bool $plugin
     * @return callable|object
     */
    protected function create($name, array $args = [], callable $callback = null, $plugin = true)
    {
        return ($plugin ? $this($this->configured($name), $args) : null) ?? (
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
                    ($param && (!$args || is_string(key($args))) ? [$param => $service] : []) + $this->args($args)
                );

                continue;
            }

            $this->resolve($args);
        }

        return $service;
    }

    /**
     * @param array|callable|object|string $name
     * @return callable|null
     */
    protected function invokable($name)
    {
        return Arg::CALL === $name[0] ? substr($name, 1) : $this->listener($this->plugin($name, [], function($name) {
            return $this->create(Arg::EVENT_MODEL, [Arg::EVENT => $name]);
        }));
    }

    /**
     * @param array|callable|object|string $config
     * @param array $args
     * @param callable $callback
     * @return array|callable|object|string
     */
    protected function invoke($config, array $args = [], callable $callback = null)
    {
        return $this->signal($config, $args, $callback ?? $this);
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
                $param->isDefaultValueAvailable() &&
                $matched[] = $param->getDefaultValue();
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
        !$parent->name() &&
            $parent[Arg::NAME] = $this->resolve($config->name());

        $config->args() &&
            $parent[Arg::ARGS] = is_string(key($config->args())) ? $config->args() + $parent->args() : $config->args();

        $config->calls() &&
            $parent[Arg::CALLS] = $config->merge() ? array_merge($parent->calls(), $config->calls()) : $config->calls();

        $config->param() &&
            $parent[Arg::PARAM] = $config->param();

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
            return $this->build(explode(Arg::SERVICE_SEPARATOR, $config), $args, $callback, true);
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

        if (!$parent) {
            return $this->hydrate($config, $this->build(explode(Arg::SERVICE_SEPARATOR, $name), $args));
        }

        if (!$parent instanceof Plugin) {
            return $this->hydrate($config, $this->plugin($this->solve($parent), $args));
        }

        if ($name == $parent->name()) {
            return $this->hydrate($config, $this->make($name, $args));
        }

        return $this->provide($this->merge(clone $parent, $config), $args);
    }

    /**
     * @param $plugin
     * @param array $config
     * @param array $args
     * @param callable|null $callback
     * @return array|callable|object|string
     */
    protected function relay($plugin, array $config = [], array $args = [], callable $callback = null)
    {
        return !$config ? $this->invoke($plugin, $args, $callback) :
            $this->relay([$plugin, array_shift($config)], $config, $args, $callback);
    }

    /**
     * @param $config
     * @param array $args
     * @param callable $callback
     * @return array|callable|Plugin|null|object|Resolvable|string
     * @throws RuntimeException
     */
    protected function resolvable($config, array $args = [], callable $callback = null)
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
            return $this->call($config->config(), $args + $this->args($config->args()));
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

        return $callback ? $callback($config) : $this->resolver($config);
    }

    /**
     * @param $config
     * @param array $args
     * @return array|callable|Plugin|null|object|Resolvable|string
     * @throws RuntimeException
     */
    protected function resolve($config, array $args = [])
    {
        return $this->resolvable($config, $args);
    }

    /**
     * @param $config
     * @return callable|mixed|null|object
     */
    protected function resolver($config)
    {
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
     * @param array $config
     * @param array $args
     * @param callable|null $callback
     * @return array|callable|object|string
     */
    protected function transmit(array $config = [], array $args = [], callable $callback = null)
    {
        return $this->relay($this->invokable(array_shift($config)), $config, $args, $callback);
    }

    /**
     * @param array|object|string|\Traversable $event
     * @param array $args
     * @param callable $callback
     * @return mixed|null
     */
    public function trigger($event, array $args = [], callable $callback = null)
    {
        return $this->event($event instanceof Event ? $event : $this($event) ?? $event, $args, $callback);
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
