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
use Mvc5\Plugin\Gem\Copy;
use Mvc5\Plugin\Gem\Dependency;
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
use Mvc5\Plugin\Gem\SignalArgs;
use Mvc5\Plugin\Gem\Value;
use Mvc5\Resolvable;
use Mvc5\Service\Config as Container;
use RuntimeException;

trait Resolver
{
    /**
     *
     */
    use Build;
    use Container;
    use Generator;
    use Initializer;

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
     */
    function __construct($config = null, callable $provider = null, $scope = null)
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
     * @param Closure $callback
     * @param $scope
     * @return Closure
     */
    protected function bind(Closure $callback, $scope)
    {
        return Closure::bind($callback, $scope, $scope);
    }

    /**
     * @param array|callable|object|string $config
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     * @throws \RuntimeException
     */
    function call($config, array $args = [], callable $callback = null)
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
            return function(...$args) use($config) {
                return $this->call($config, $this->variadic($args));
            };
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
     * @return callable|mixed|object
     */
    protected function fallback($name)
    {
        return $this(Arg::EVENT_MODEL, [Arg::EVENT => $name]) ?: $this->signal(new Exception, [$name]);
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

        if ($config instanceof Dependency) {
            return $this->shared($config->name()) ?? $this->initialize($config->name(), $config->config());
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
            return function(...$args) use ($config) {
                return $this->call(
                    $this->resolve($config->config()), $this->vars($this->variadic($args), $config->args())
                );
            };
        }

        if ($config instanceof Invokable) {
            return function(...$args) use ($config) {
                return $this->resolve($config->config(), $this->vars($this->variadic($args), $config->args()));
            };
        }

        if ($config instanceof FileInclude) {
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

        if ($config instanceof Provide) {
            return $this->signal(
                $this->provider() ?: new Exception, [$config->config(), $this->vars($args, $config->args())]
            );
        }

        return $this->signal(new Exception, [$config]);
    }

    /**
     * @param string $name
     * @return mixed
     */
    function get($name)
    {
        return $this->shared($name) ?? $this($name);
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
     * @param array|callable|object|string $name
     * @return callable|null
     */
    protected function invokable($name)
    {
        return Arg::CALL === $name[0] ? substr($name, 1) :
            $this->listener($this->plugin($name, [], $this) ?: $this->fallback($name));
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
     * @param $plugin
     * @return callable|null
     */
    protected function listener($plugin)
    {
        return !$plugin instanceof Event ? $plugin : function(...$args) use ($plugin) {
            return $this->event($plugin, $this->variadic($args));
        };
    }

    /**
     * @param Plugin $parent
     * @param Plugin $config
     * @param null|string $name
     * @return Plugin
     */
    protected function merge(Plugin $parent, Plugin $config, $name = null)
    {
        !$parent->name() &&
            $parent[Arg::NAME] = $name ?? $this->resolve($config->name());

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
     * @param string $config
     * @param array $args
     * @param callable|null $callback
     * @return array|callable|null|object|string
     */
    function plugin($config, array $args = [], callable $callback = null)
    {
        if (!$config) {
            return $config;
        }

        if (is_string($config)) {
            return $this->build(explode(Arg::SERVICE_SEPARATOR, $config), $args, $callback);
        }

        if (is_array($config)) {
            return $this->plugin(array_shift($config), $args + $this->args($config), $callback);
        }

        if ($config instanceof Closure) {
            return $this->invoke($this->scoped($config), $args);
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

        if ($name == $parent->name()) {
            return $this->hydrate($config, $this->make($name, $args));
        }

        return $this->provide($this->merge(clone $parent, $config, $name), $args);
    }

    /**
     * @return callable
     */
    protected function provider()
    {
        return $this->provider;
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
            $this->repeat($plugin, array_shift($config), $config, $args, $callback);
    }

    /**
     * @param $plugin
     * @param $name
     * @param array $config
     * @param array $args
     * @param callable|null $callback
     * @return array|callable|object|string
     */
    protected function repeat($plugin, $name, array $config = [], array $args = [], callable $callback = null)
    {
        return !$config ? $this->invoke([$plugin, $name], $args, $callback) : $this->repeat(
            $this->invoke([$plugin, $name], $args, $callback), array_shift($config), $config, $args, $callback
        );
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
            $c > Arg::MAX_RECURSION ? $this->signal(new Exception, [$config]) :
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
     * @param object $scope
     * @return object
     */
    protected function scope($scope = null)
    {
        return null !== $scope ? $this->scope = $scope : $this->scope;
    }

    /**
     * @param Closure $callback
     * @return Closure
     */
    protected function scoped(Closure $callback)
    {
        return $this->scope ? $this->bind($callback, $this->scope === true ? $this : $this->scope) : $callback;
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
    function trigger($event, array $args = [], callable $callback = null)
    {
        return $this->event($event instanceof Event ? $event : $this($event) ?? $event, $args, $callback);
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
     * @param string $name
     * @param array $args
     * @return array|callable|null|object|string
     */
    function __invoke($name, array $args = [])
    {
        return $this->plugin($name, $args, $this->provider() ?? function(){});
    }
}
