<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Mvc5\Arg;
use Mvc5\Event\Event;
use Mvc5\Resolvable;
use Mvc5\Signal;

trait Service
{
    /**
     * @param array|callable|object|string $plugin
     * @param array $args
     * @param callable|null $callback
     * @return callable|mixed|null|object
     */
    function call($plugin, array $args = [], callable $callback = null)
    {
        if (is_string($plugin)) {
            return $this->transmit(explode(Arg::CALL_SEPARATOR, $plugin), $args, $callback);
        }

        if ($plugin instanceof Event) {
            return $this->event($plugin, $args, $callback);
        }

        return $this->invoke($plugin instanceof Resolvable ? $this->resolve($plugin) : $plugin, $args, $callback);
    }

    /**
     * @param array|callable|object|string $plugin
     * @return callable
     */
    protected function callable($plugin) : callable
    {
        if (is_string($plugin)) {
            return function(...$argv) use($plugin) {
                return $this->call($plugin, $this->variadic($argv));
            };
        }

        if (is_array($plugin)) {
            return is_string($plugin[0]) ? $plugin : [$this->resolve($plugin[0]), $plugin[1]];
        }

        return $plugin instanceof \Closure ? $plugin : $this->listener($this->resolve($plugin));
    }

    /**
     * @param string $name
     * @return callable|mixed|object
     */
    protected function fallback(string $name)
    {
        return $this(Arg::EVENT_MODEL, [Arg::EVENT => $name]) ?: Unresolvable::plugin($name);
    }

    /**
     * @param callable|object|string $plugin
     * @return callable|null
     */
    protected function invokable($plugin)
    {
        return Arg::CALL === $plugin[0] ? substr($plugin, 1) :
            $this->listener($this->plugin($plugin, [], $this) ?: $this->fallback($plugin));
    }

    /**
     * @param array|callable|object|string $plugin
     * @param array $args
     * @param callable|null $callback
     * @return array|callable|object|string
     */
    protected function invoke($plugin, array $args = [], callable $callback = null)
    {
        return Signal::emit($plugin, $args, $callback ?? $this);
    }

    /**
     * @param $plugin
     * @param array $name
     * @param array $args
     * @param callable|null $callback
     * @return array|callable|object|string
     */
    protected function relay($plugin, array $name = [], array $args = [], callable $callback = null)
    {
        return !$name ? $this->invoke($plugin, $args, $callback) :
            $this->repeat($plugin, array_shift($name), $name, $args, $callback);
    }

    /**
     * @param $plugin
     * @param string $method
     * @param array $name
     * @param array $args
     * @param callable|null $callback
     * @return array|callable|object|string
     */
    protected function repeat($plugin, string $method, array $name = [], array $args = [], callable $callback = null)
    {
        return !$name ? $this->invoke([$plugin, $method], $args, $callback) : $this->repeat(
            $this->invoke([$plugin, $method], [], $callback), array_shift($name), $name, $args, $callback
        );
    }

    /**
     * @param string[] $name
     * @param array $args
     * @param callable|null $callback
     * @return array|callable|object|string
     */
    protected function transmit(array $name, array $args = [], callable $callback = null)
    {
        return $this->relay($this->invokable(array_shift($name)), $name, $args, $callback);
    }

    /**
     * @param $plugin
     * @param array $args
     * @return array|callable|null|object|string
     */
    abstract function __invoke($plugin, array $args = []);
}
