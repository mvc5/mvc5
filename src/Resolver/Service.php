<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Mvc5\Arg;
use Mvc5\Event\Event;
use Mvc5\Resolvable;

trait Service
{
    /**
     * @param array|callable|object|string $config
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     */
    function call($config, array $args = [], callable $callback = null)
    {
        if (is_string($config)) {
            return $this->transmit(explode(Arg::CALL_SEPARATOR, $config), $args, $callback);
        }

        if ($config instanceof Event) {
            return $this->event($config, $args, $callback);
        }

        return $this->invoke($config instanceof Resolvable ? $this->resolve($config) : $config, $args, $callback);
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

        return $config instanceof \Closure ? $config : $this->listener($this->resolve($config));
    }

    /**
     * @param $name
     * @return callable|mixed|object
     */
    protected function fallback($name)
    {
        return $this(Arg::EVENT_MODEL, [Arg::EVENT => $name]) ?: Unresolvable::plugin($name);
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
     * @param string $name
     * @param array $args
     * @return array|callable|null|object|string
     */
    abstract function __invoke($name, array $args = []);
}
