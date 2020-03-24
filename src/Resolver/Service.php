<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Closure;
use Mvc5\Event\Event;
use Mvc5\Resolvable;
use Mvc5\Signal;

use function array_shift;
use function explode;
use function is_array;
use function is_string;
use function substr;

use const Mvc5\{ CALL, CALL_SEPARATOR, EVENT, EVENT_MODEL };

trait Service
{
    /**
     * @param array|callable|Event|Resolvable|string $plugin
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     * @throws \Throwable
     */
    function call($plugin, array $args = [], callable $callback = null)
    {
        if (is_string($plugin)) {
            return $this->transmit(explode(CALL_SEPARATOR, $plugin), $args, $callback);
        }

        if ($plugin instanceof Event) {
            return $this->event($plugin, $args, $callback);
        }

        return $this->invoke($plugin instanceof Resolvable ? $this->resolve($plugin) : $plugin, $args, $callback);
    }

    /**
     * @param callable|mixed $plugin
     * @return callable
     */
    protected function callable($plugin) : callable
    {
        if (is_string($plugin)) {
            return fn(...$argv) => $this->call($plugin, $this->variadic($argv));
        }

        if (is_array($plugin)) {
            return is_string($plugin[0]) ? $plugin : [$this->resolve($plugin[0]), $plugin[1]];
        }

        return $plugin instanceof Closure ? $plugin : $this->listener($this->resolve($plugin));
    }

    /**
     * @param string $name
     * @return callable|mixed
     * @throws \Throwable
     */
    protected function fallback(string $name)
    {
        return $this(EVENT_MODEL, [EVENT => $name]) ?? Unresolvable::plugin($name);
    }

    /**
     * @param string $plugin
     * @return callable|mixed
     * @throws \Throwable
     */
    protected function invokable(string $plugin)
    {
        return CALL === $plugin[0] ? substr($plugin, 1) :
            $this->listener($this->plugin($plugin, [], $this) ?? $this->fallback($plugin));
    }

    /**
     * @param callable $callable
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     * @throws \Throwable
     */
    protected function invoke(callable $callable, array $args = [], callable $callback = null)
    {
        return Signal::emit($callable, $args, $callback ?? $this);
    }

    /**
     * @param $plugin
     * @param array $name
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     * @throws \Throwable
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
     * @return mixed
     * @throws \Throwable
     */
    protected function repeat($plugin, string $method, array $name = [], array $args = [], callable $callback = null)
    {
        return !$name ? $this->invoke([$plugin, $method], $args, $callback) : $this->repeat(
            $this->invoke([$plugin, $method], [], $callback), array_shift($name), $name, $args, $callback
        );
    }

    /**
     * @param array $name
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     * @throws \Throwable
     */
    protected function transmit(array $name, array $args = [], callable $callback = null)
    {
        return $this->relay($this->invokable(array_shift($name)), $name, $args, $callback);
    }

    /**
     * @param string|mixed $plugin
     * @param array $args
     * @return mixed
     */
    abstract function __invoke($plugin, array $args = []);
}
