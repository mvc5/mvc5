<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Mvc5\Arg;
use Mvc5\Plugin\Gem\Args;
use Mvc5\Plugin\Gem\Call;
use Mvc5\Plugin\Gem\Calls;
use Mvc5\Plugin\Gem\Child;
use Mvc5\Plugin\Gem\Config;
use Mvc5\Plugin\Gem\Copy;
use Mvc5\Plugin\Gem\Factory;
use Mvc5\Plugin\Gem\FileInclude;
use Mvc5\Plugin\Gem\Filter;
use Mvc5\Plugin\Gem\Gem;
use Mvc5\Plugin\Gem\Invokable;
use Mvc5\Plugin\Gem\Invoke;
use Mvc5\Plugin\Gem\Link;
use Mvc5\Plugin\Gem\Param;
use Mvc5\Plugin\Gem\Plug;
use Mvc5\Plugin\Gem\Plugin;
use Mvc5\Plugin\Gem\Provide;
use Mvc5\Plugin\Gem\Scoped;
use Mvc5\Plugin\Gem\Shared;
use Mvc5\Plugin\Gem\SignalArgs;
use Mvc5\Plugin\Gem\Value;
use Mvc5\Resolvable;

trait Resolver
{
    /**
     *
     */
    use Build;
    use Container;
    use Generator;
    use Service;

    /**
     * @var callable
     */
    protected $provider;

    /**
     * @var object
     */
    protected $scope;

    /**
     * @param array|\ArrayAccess $config
     * @param callable $provider
     * @param object $scope
     * @param bool $strict
     */
    function __construct($config = null, callable $provider = null, $scope = null, $strict = false)
    {
        $config && $this->config = $config;

        isset($config[Arg::CONTAINER])
            && $this->container = $config[Arg::CONTAINER];

        isset($config[Arg::EVENTS])
            && $this->events = $config[Arg::EVENTS];

        isset($config[Arg::SERVICES])
            && $this->services = $config[Arg::SERVICES];

        $provider && $this->provider = $this->resolve($provider);

        $scope && $this->scope = $this->resolve($scope);

        $strict && $this->strict = $strict;
    }

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
     * @param array $child
     * @param array $parent
     * @return array
     */
    protected function arguments(array $child, array $parent)
    {
        return !$parent ? $child : (
            !$child ? $parent : (is_string(key($child)) ? $child + $parent : array_merge($child, $parent))
        );
    }

    /**
     * @param \Closure $callback
     * @param object $object
     * @param bool $scoped
     * @return \Closure
     */
    protected function bind(\Closure $callback, $object, $scoped)
    {
        return \Closure::bind($callback, $object, $scoped ? $object : null);
    }

    /**
     * @param Child $config
     * @param array $args
     * @return array|callable|object|string
     */
    protected function child(Child $config, array $args = [])
    {
        return $this->provide($this->merge($this->parent($config->parent()), $config), $args);
    }

    /**
     * @param array|callable|null|object|string $value
     * @param array|\Traversable $filters
     * @param array $args
     * @param $param
     * @return mixed
     */
    protected function filter($value, $filters = [], array $args = [], $param = null)
    {
        $result = $value;

        foreach($filters as $filter) {
            $value = $this->invoke(
                $this->callable($filter), $param ? [$param => $result] + $args : array_merge([$result], $args)
            );

            if (false === $value) {
                return $result;
            }

            if (null === $value) {
                return null;
            }

            $result = $value;
        }

        return $result;
    }

    /**
     * @param Filter $config
     * @param array $args
     * @return mixed
     */
    protected function filterable(Filter $config, array $args = [])
    {
        return $this->filter(
            $this->resolve($config->config()), $this->resolve($config->filter()), $args, $config->param()
        );
    }

    /**
     * @param $config
     * @param array $args
     * @return mixed|callable
     */
    protected function gem($config, array $args = [])
    {
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

        if ($config instanceof Shared) {
            return $this->shared($config->name(), $config->config());
        }

        if ($config instanceof Param) {
            return $this->resolve($this->param($config->name()), $args);
        }

        if ($config instanceof Call) {
            return $this->call($this->resolve($config->config()), $this->vars($args, $config->args()));
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
            return $this->filterable($config, $this->vars($args, $config->args()));
        }

        if ($config instanceof Plug) {
            return $this->configured($config->name());
        }

        if ($config instanceof Invoke) {
            return function(...$argv) use ($config) {
                return $this->call(
                    $this->resolve($config->config()), $this->vars($this->variadic($argv), $config->args())
                );
            };
        }

        if ($config instanceof Invokable) {
            return function(...$argv) use ($config) {
                return $this->resolve($config->config(), $this->vars($this->variadic($argv), $config->args()));
            };
        }

        if ($config instanceof FileInclude) {
            /** @var callable $include */
            $include = new class() {
                function __invoke($file) {
                    return include $file;
                }
            };

            return $include($this->resolve($config->config()));
        }

        if ($config instanceof Copy) {
            return clone $this->resolve($config->config(), $args);
        }

        if ($config instanceof Value) {
            return $config->config();
        }

        if ($config instanceof Scoped) {
            return $this->scoped($config->closure(), $config->scoped());
        }

        if ($config instanceof Provide) {
            return ($this->provider() ?: new Unresolvable)($config->config(), $this->vars($args, $config->args()));
        }

        return Unresolvable::plugin($config);
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
                    is_string($method) ? [$service, $method] : $this->callable($method),
                    ($param && (!$args || is_string(key($args))) ? [$param => $service] : []) + $this->args($args)
                );

                continue;
            }

            $this->resolve($args);
        }

        return $service;
    }

    /**
     * @param Plugin $parent
     * @param Plugin $child
     * @param null|string $name
     * @param array $config
     * @return Plugin
     */
    protected function merge(Plugin $parent, Plugin $child, $name = null, array $config = [])
    {
        !$parent->name() &&
            $config[Arg::NAME] = $name ?? $this->resolve($child->name());

        $child->args() &&
            $config[Arg::ARGS] = is_string(key($child->args())) ? $child->args() + $parent->args() : $child->args();

        $child->calls() &&
            $config[Arg::CALLS] = $child->merge() ? array_merge($parent->calls(), $child->calls()) : $child->calls();

        $child->param() &&
            $config[Arg::PARAM] = $child->param();

        return $config ? $parent->with($config) : $parent;
    }

    /**
     * @param string $name
     * @return mixed
     */
    function param($name)
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
     * @param $config
     * @param array $args
     * @param callable|null $callback
     * @param null|string $previous
     * @return array|callable|null|object|string
     */
    function plugin($config, array $args = [], callable $callback = null, $previous = null)
    {
        if (!$config) {
            return $config;
        }

        if (is_string($config)) {
            return $this->build(explode(Arg::SERVICE_SEPARATOR, $config), $args, $callback);
        }

        if (is_array($config)) {
            return $this->pluginArray(array_shift($config), $args + $this->args($config), $callback, $previous);
        }

        if ($config instanceof \Closure) {
            return $this->invoke($this->scoped($config), $args);
        }

        return $this->resolve($config, $args);
    }

    /**
     * @param $config
     * @param array $args
     * @param callable|null $callback
     * @param null|string $previous
     * @return array|callable|null|object|string
     */
    protected function pluginArray($config, array $args = [], callable $callback = null, $previous = null)
    {
        return $previous && $previous === $config ?
            $this->callback($config, true, $args, $callback) : $this->plugin($config, $args, $callback);
    }

    /**
     * @param Plugin $config
     * @param array $args
     * @return callable|null|object
     */
    protected function provide(Plugin $config, array $args = [])
    {
        $name   = $this->resolve($config->name());
        $parent = $this->configured($name);

        $args && is_string(key($args)) && $config->args() && $args += $this->args($config->args());

        !$args && $args = $this->args($config->args());

        if (!$parent) {
            return $this->hydrate($config, $this->combine(explode(Arg::SERVICE_SEPARATOR, $name), $args));
        }

        if (!$parent instanceof Plugin) {
            return $this->hydrate(
                $config, $name === $parent ? $this->make($name, $args) : $this->plugin($this->resolve($parent), $args)
            );
        }

        if ($name === $parent->name()) {
            return $this->hydrate($config, $this->make($name, $args));
        }

        return $this->provide($this->merge($parent, $config, $name), $args);
    }

    /**
     * @return callable
     */
    protected function provider()
    {
        return $this->provider;
    }

    /**
     * @param $config
     * @param array $args
     * @param callable $callback
     * @param int $c
     * @return array|callable|Plugin|null|object|Resolvable|string
     */
    protected function resolvable($config, array $args = [], callable $callback = null, $c = 0)
    {
        return !$config instanceof Resolvable ? $config : (
            $c > Arg::MAX_RECURSION ? Unresolvable::plugin($config) :
                $this->resolvable($this->solve($config, $args, $callback), $args, $callback, ++$c)
        );
    }

    /**
     * @param $config
     * @param array $args
     * @return array|callable|Plugin|null|object|Resolvable|string
     */
    protected function resolve($config, array $args = [])
    {
        return $this->resolvable($config, $args);
    }

    /**
     * @param $config
     * @param array $args
     * @return callable|mixed|null|object
     */
    protected function resolver($config, array $args = [])
    {
        return $this->call($this->provider() ?: Arg::SERVICE_RESOLVER, [$config, $args]);
    }

    /**
     * @param object $scope
     * @return object
     */
    function scope($scope = null)
    {
        return null !== $scope ? $this->scope = $scope : $this->scope;
    }

    /**
     * @param \Closure $callback
     * @param bool $scoped
     * @return \Closure
     */
    protected function scoped(\Closure $callback, $scoped = false)
    {
        return $this->scope ? $this->bind($callback, $this->scope === true ? $this : $this->scope, $scoped) : $callback;
    }

    /**
     * @param $config
     * @param array $args
     * @param callable $callback
     * @return mixed|callable
     */
    protected function solve($config, array $args = [], callable $callback = null)
    {
        return $config instanceof Gem ? $this->gem($config, $args) : (
            $callback ? $callback($config, $args) : $this->resolver($config, $args)
        );
    }

    /**
     * @return string
     */
    function serialize()
    {
        return serialize([$this->config, $this->events, $this->provider, $this->scope, $this->services, $this->strict]);
    }

    /**
     * @param string $serialized
     */
    function unserialize($serialized)
    {
        list(
            $this->config, $this->events, $this->provider, $this->scope, $this->services, $this->strict
        ) = unserialize($serialized);
    }

    /**
     * @param array $args
     * @return array
     */
    protected function variadic(array $args)
    {
        return $args && $args[0] instanceof SignalArgs ? $args[0]->args() : $args;
    }

    /**
     * @param array $child
     * @param array $parent
     * @return array
     */
    protected function vars(array $child = [], array $parent = [])
    {
        return $this->arguments($child, $this->args($parent));
    }

    /**
     *
     */
    function __clone()
    {
        is_object($this->config) &&
            $this->config = clone $this->config;

        if (is_object($this->container)) {
            $this->container = clone $this->container;

            if (isset($this->config[Arg::CONTAINER])) {
                $this->config[Arg::CONTAINER] = $this->container;
            }
        }

        if (is_object($this->events)) {
            $this->events = clone $this->events;

            if (isset($this->config[Arg::EVENTS])) {
                $this->config[Arg::EVENTS] = $this->events;
            }
        }

        if (is_object($this->services)) {
            $this->services = clone $this->services;

            if (isset($this->config[Arg::SERVICES])) {
                $this->config[Arg::SERVICES] = $this->services;
            }
        }

        is_object($this->scope) &&
            $this->scope = clone $this->scope;
    }

    /**
     * @param $name
     * @param array $args
     * @return array|callable|null|object|string
     */
    function __invoke($name, array $args = [])
    {
        return $this->plugin($name, $args, $this->provider() ?? function(){});
    }
}
