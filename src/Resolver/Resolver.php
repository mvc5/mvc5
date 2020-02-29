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
use Mvc5\Plugin\Gem\Expect;
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

use function array_merge;
use function array_shift;
use function explode;
use function is_array;
use function is_string;
use function is_object;
use function key;
use function substr;

trait Resolver
{
    /**
     *
     */
    use Base;
    use Build;
    use Generator;
    use Service;

    /**
     * @var callable
     */
    protected $provider;

    /**
     * @var bool|object|null
     */
    protected $scope;

    /**
     * @param array|\ArrayAccess|null $config
     * @param callable|null $provider
     * @param bool|object|null $scope
     * @param bool $strict
     * @throws \Throwable
     */
    function __construct($config = null, callable $provider = null, $scope = null, bool $strict = false)
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
     * @param array|mixed $args
     * @return array|mixed
     * @throws \Throwable
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
    protected function arguments(array $child, array $parent) : array
    {
        return !$parent ? $child : (
            !$child ? $parent : (is_string(key($child)) ? $child + $parent : [...$child, ...$parent])
        );
    }

    /**
     * @param \Closure $callback
     * @param object $object
     * @param bool $scoped
     * @return \Closure
     */
    protected function bind(\Closure $callback, $object, bool $scoped) : \Closure
    {
        return \Closure::bind($callback, $object, $scoped ? $object : null);
    }

    /**
     * @param Child $child
     * @param array $args
     * @return mixed
     * @throws \Throwable
     */
    protected function child(Child $child, array $args = [])
    {
        return $this->provide($this->merge($this->parent($child->parent()), $child), $args);
    }

    /**
     * @param mixed $value
     * @param iterable $filters
     * @param array $args
     * @param string|null $param
     * @return mixed
     * @throws \Throwable
     */
    protected function filter($value, iterable $filters = [], array $args = [], string $param = null)
    {
        $result = $value;

        foreach($filters as $filter) {
            $value = $this->invoke(
                $this->callable($filter), $param ? [$param => $result] + $args : [$result, ...$args]
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
     * @param Filter $filter
     * @param array $args
     * @return mixed
     * @throws \Throwable
     */
    protected function filterable(Filter $filter, array $args = [])
    {
        return $this->filter(
            $this->resolve($filter->config()), $this->resolve($filter->filter()), $args, $filter->param()
        );
    }

    /**
     * @param Gem $gem
     * @param array $args
     * @return callable|mixed
     * @throws \Throwable
     */
    protected function gem(Gem $gem, array $args = [])
    {
        if ($gem instanceof Factory) {
            return $this->invoke($this->child($gem, $args));
        }

        if ($gem instanceof Calls) {
            return $this->hydrate($gem, $this->resolve($gem->name(), $args));
        }

        if ($gem instanceof Child) {
            return $this->child($gem, $args);
        }

        if ($gem instanceof Plugin) {
            return $this->provide($gem, $args);
        }

        if ($gem instanceof Shared) {
            return $this->shared($gem->name(), $gem->config(), $args);
        }

        if ($gem instanceof Param) {
            return $this->resolve($this->param($gem->name()), $args);
        }

        if ($gem instanceof Call) {
            return $this->call($this->resolve($gem->config()), $this->vars($args, $gem->args()));
        }

        if ($gem instanceof Args) {
            return $this->args($gem->config());
        }

        if ($gem instanceof Config) {
            return $this->config();
        }

        if ($gem instanceof Link) {
            return $this;
        }

        if ($gem instanceof Filter) {
            return $this->filterable($gem, $this->vars($args, $gem->args()));
        }

        if ($gem instanceof Plug) {
            return $this->configured($gem->name());
        }

        if ($gem instanceof Invoke) {
            return fn(...$argv) => $this->resolve($this->call(
                $this->resolve($gem->config()), $this->vars($this->variadic($argv), $gem->args())
            ));
        }

        if ($gem instanceof Invokable) {
            return fn(...$argv) => $this->resolve($gem->config(), $this->vars($this->variadic($argv), $gem->args()));
        }

        if ($gem instanceof FileInclude) {
            return (new class() {
                function __invoke($file) {
                    return include $file;
                }
            })($this->resolve($gem->config()));
        }

        if ($gem instanceof Copy) {
            return clone $this->resolve($gem->config(), $args);
        }

        if ($gem instanceof Value) {
            return $gem->config();
        }

        if ($gem instanceof Scoped) {
            return $this->scoped($gem->closure(), $gem->scoped());
        }

        if ($gem instanceof Provide) {
            return ($this->provider() ?? new Unresolvable)($gem->config(), $this->vars($args, $gem->args()));
        }

        if ($gem instanceof Expect) {
            try {
                return $this->resolve($gem->plugin(), $args);
            } catch(\Throwable $exception) {
                return $this->resolve($gem->exception(), $gem->args($exception, $args));
            }
        }

        return Unresolvable::plugin($gem);
    }

    /**
     * @param Plugin $plugin
     * @param object $service
     * @return object
     * @throws \Throwable
     */
    protected function hydrate(Plugin $plugin, $service)
    {
        foreach($plugin->calls() as $method => $args) {
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
                $param  = $plugin->param();

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
     * @param string|null $name
     * @param array $config
     * @return Plugin
     * @throws \Throwable
     */
    protected function merge(Plugin $parent, Plugin $child, string $name = null, array $config = []) : Plugin
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
     * @param array|string $name
     * @return mixed
     */
    function param($name)
    {
        if (is_string($name)) {
            return param($this->config(), $name);
        }

        $matched = [];

        foreach($name as $key) {
            $matched[$key] = $this->config()[$key] ?? null;
        }

        return $matched;
    }

    /**
     * @param string $parent
     * @return Plugin
     * @throws \Throwable
     */
    protected function parent(string $parent) : Plugin
    {
        return $this->configured($this->resolve($parent));
    }

    /**
     * @param string|mixed $plugin
     * @param array $args
     * @param callable|null $callback
     * @param string|null $previous
     * @return mixed
     * @throws \Throwable
     */
    function plugin($plugin, array $args = [], callable $callback = null, string $previous = null)
    {
        if (!$plugin) {
            return $plugin;
        }

        if (is_string($plugin)) {
            return $this->build(explode(Arg::SERVICE_SEPARATOR, $plugin), $args, $callback);
        }

        if (is_array($plugin)) {
            return $this->pluginArray(array_shift($plugin), $args + $this->args($plugin), $callback, $previous);
        }

        if ($plugin instanceof \Closure) {
            return $this->invoke($this->scoped($plugin), $args);
        }

        return $this->resolve($plugin, $args);
    }

    /**
     * @param string|mixed $plugin
     * @param array $args
     * @param callable|null $callback
     * @param string|null $previous
     * @return mixed
     * @throws \Throwable
     */
    protected function pluginArray($plugin, array $args = [], callable $callback = null, string $previous = null)
    {
        return $previous && $previous === $plugin ?
            $this->callback($plugin, true, $args, $callback) : $this->plugin($plugin, $args, $callback);
    }

    /**
     * @param Plugin $plugin
     * @param array $args
     * @return callable|object|null
     * @throws \Throwable
     */
    protected function provide(Plugin $plugin, array $args = [])
    {
        $name   = $this->resolve($plugin->name());
        $parent = $this->configured($name);

        $args && is_string(key($args)) && $plugin->args() && $args += $this->args($plugin->args());

        !$args && $args = $this->args($plugin->args());

        if (!$parent) {
            return $this->hydrate($plugin, $this->combine(explode(Arg::SERVICE_SEPARATOR, $name), $args));
        }

        if (!$parent instanceof Plugin) {
            return $this->hydrate(
                $plugin, $name === $parent ? $this->make($name, $args) : $this->provision($this->resolve($parent), $args)
            );
        }

        if ($name === $parent->name()) {
            return $this->hydrate($plugin, $this->make($name, $args));
        }

        return $this->provide($this->merge($parent, $plugin, $name), $args);
    }

    /**
     * @return callable|null
     */
    protected function provider() : ?callable
    {
        return $this->provider;
    }

    /**
     * @param $plugin
     * @param array $args
     * @return mixed
     * @throws \ReflectionException
     * @throws \Throwable
     */
    protected function provision($plugin, array $args)
    {
        return $plugin instanceof \Closure && (new \ReflectionFunction($plugin))->getClosureThis() ?
            $this->invoke($plugin, $args) : $this->plugin($plugin, $args);
    }

    /**
     * @param Resolvable|mixed $plugin
     * @param array $args
     * @param callable|null $callback
     * @param int $c
     * @return mixed
     * @throws \Throwable
     */
    protected function resolvable($plugin, array $args = [], callable $callback = null, int $c = 0)
    {
        return !$plugin instanceof Resolvable ? $plugin : (
            $c > Arg::MAX_RECURSION ? Unresolvable::plugin($plugin) :
                $this->resolvable($this->solve($plugin, $args, $callback), $args, $callback, ++$c)
        );
    }

    /**
     * @param Resolvable|mixed $plugin
     * @param array $args
     * @return mixed
     * @throws \Throwable
     */
    protected function resolve($plugin, array $args = [])
    {
        return $this->resolvable($plugin, $args);
    }

    /**
     * @param string|mixed $plugin
     * @param array $args
     * @return mixed
     * @throws \Throwable
     */
    protected function resolver($plugin, array $args = [])
    {
        return $this->call($this->provider() ?? Arg::SERVICE_RESOLVER, [$plugin, $args]);
    }

    /**
     * @param object $scope
     * @return bool|object|null
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
    protected function scoped(\Closure $callback, bool $scoped = false) : \Closure
    {
        return $this->scope ? $this->bind($callback, $this->scope === true ? $this : $this->scope, $scoped) : $callback;
    }

    /**
     * @param Gem|mixed $plugin
     * @param array $args
     * @param callable|null $callback
     * @return callable|mixed
     * @throws \Throwable
     */
    protected function solve($plugin, array $args = [], callable $callback = null)
    {
        return $plugin instanceof Gem ? $this->gem($plugin, $args) : (
            $callback ? $callback($plugin, $args) : $this->resolver($plugin, $args)
        );
    }

    /**
     * @param array $args
     * @return array
     */
    protected function variadic(array $args) : array
    {
        return $args && $args[0] instanceof SignalArgs ? $args[0]->args() : $args;
    }

    /**
     * @param array $child
     * @param array $parent
     * @return array
     * @throws \Throwable
     */
    protected function vars(array $child = [], array $parent = []) : array
    {
        return $this->arguments($child, $this->args($parent));
    }

    /**
     * @param mixed $plugin
     * @param array $args
     * @return mixed
     * @throws \Throwable
     */
    function __call($plugin, array $args = [])
    {
        return $this->call($plugin, $args);
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
     * @param mixed $plugin
     * @param array $args
     * @return mixed
     * @throws \Throwable
     */
    function __invoke($plugin, array $args = [])
    {
        return $this->plugin($plugin, $args, $this->provider() ?? function(){});
    }

    /**
     * @return array
     */
    function __serialize() : array
    {
        return [$this->config, $this->events, $this->provider, $this->scope, $this->services, $this->strict];
    }

    /**
     * @param array $data
     */
    function __unserialize(array $data) : void
    {
        list($this->config, $this->events, $this->provider, $this->scope, $this->services, $this->strict) = $data;
    }
}

/**
 * @param array|\ArrayAccess $config
 * @param string $name
 * @return mixed
 */
function param($config, string $name)
{
    $name = explode(Arg::CALL_SEPARATOR, $name);
    $value = $config[array_shift($name)];

    foreach($name as $n) {
        $value = $value[$n];
    }

    return $value;
}
