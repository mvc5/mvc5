<?php
/**
 *
 */

namespace Mvc5\Event;

use Mvc5\Signal as _Signal;
use Iterator;

trait Generator
{
    /**
     *
     */
    use _Signal;

    /**
     * @param array|callable|object|string $config
     * @return callable|null
     */
    protected abstract function callable($config) : callable;

    /**
     * @param callable|Event|string $event
     * @param callable $listener
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    protected function emit($event, callable $listener, array $args = [], callable $callback = null)
    {
        return is_callable($event) ? $event($listener, $args, $callback) : $this->signal($listener, $args, $callback);
    }

    /**
     * @param array|string|Iterator $event
     * @param array $args
     * @param callable $callback
     * @return mixed|null
     */
    protected function generate($event, array $args = [], callable $callback = null)
    {
        return $this->traverse($event, $this->queue($event, $args), $args, $callback);
    }

    /**
     * @param $listener
     * @param $event
     * @param $queue
     * @param $args
     * @param $callback
     * @param null $result
     * @return null
     */
    protected function iterate($listener, $event, $queue, $args, $callback, $result = null)
    {
        return !$listener || ($event instanceof Event && $event->stopped()) ? $result : $this->iterate(
            next($queue), $event, $queue, $args, $callback, $this->result($event, $listener, $args, $callback)
        );
    }

    /**
     * @param Event|object|string $event
     * @param array $args
     * @return array|Iterator|null
     */
    protected abstract function iterator($event, array $args = []);

    /**
     * @param array|Event|object|string|Iterator $event
     * @param array $args
     * @return array|Iterator
     */
    protected function queue($event, array $args = [])
    {
        return is_array($event) || $event instanceof Iterator ? $event : $this->iterator($event, $args);
    }

    /**
     * @param $event
     * @param $listener
     * @param $args
     * @param $callback
     * @return mixed
     */
    protected function result($event, $listener, $args, $callback)
    {
        return $this->emit($event, $this->callable($listener), $args, $callback);
    }

    /**
     * @param $event
     * @param $queue
     * @param $args
     * @param $callback
     * @return mixed
     */
    protected function traverse($event, $queue, $args, $callback)
    {
        return $this->iterate(current($queue), $event, $queue, $args, $callback);
    }
}
