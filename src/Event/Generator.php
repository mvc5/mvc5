<?php
/**
 *
 */

namespace Mvc5\Event;

use Mvc5\Signal;

trait Generator
{
    /**
     * @param mixed $listener
     * @return callable
     */
    protected abstract function callable($listener) : callable;

    /**
     * @param array|Event|\Iterator|object|string $event
     * @param callable $listener
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     */
    protected function emit($event, callable $listener, array $args = [], callable $callback = null)
    {
        return $event instanceof Event ? $event($listener, $args, $callback) : $this->signal($listener, $args, $callback);
    }

    /**
     * @param array|Event|\Iterator|object|string $event
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     */
    protected function generate($event, array $args = [], callable $callback = null)
    {
        return $this->iterate($event, $this->start($this->queue($event, $args)), $args, $callback);
    }

    /**
     * @param array|\Iterator $queue
     * @return mixed
     */
    protected function item($queue)
    {
        return $queue instanceof \Iterator ? $queue->current() : current($queue);
    }

    /**
     * @param array|Event|\Iterator|object|string $event
     * @param array|\Iterator $queue
     * @param array $args
     * @param callable|null $callback
     * @param mixed $result
     * @return mixed
     */
    protected function iterate($event, $queue, array $args, callable $callback = null, $result = null)
    {
        return $this->stopped($event, $queue) ? $result : $this->loop(
            $event, $queue, $args, $callback, $this->result($event, $this->item($queue), $args, $callback)
        );
    }

    /**
     * @param array|Event|\Iterator|object|string $event
     * @param array|\Iterator $queue
     * @param array $args
     * @param callable|null $callback
     * @param mixed $result
     * @return mixed
     */
    protected function loop($event, $queue, array $args, callable $callback = null, $result = null)
    {
        return $this->iterate($event, $this->step($queue), $args, $callback, $result);
    }

    /**
     * @param array|Event|\Iterator|object|string $event
     * @param array $args
     * @return array|\Iterator
     */
    protected function queue($event, array $args = [])
    {
        return is_array($event) || $event instanceof \Iterator ? $event : $this->iterator($event, $args);
    }

    /**
     * @param array|Event|\Iterator|object|string $event
     * @param mixed $current
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     */
    protected function result($event, $current, array $args = [], callable $callback = null)
    {
        return $this->emit($event, $this->callable($current), $args, $callback);
    }

    /**
     * @param callable $callable
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     */
    protected function signal(callable $callable, array $args = [], callable $callback = null)
    {
        return Signal::emit($callable, $args, $callback);
    }

    /**
     * @param array|\Iterator $queue
     * @return array|\Iterator
     */
    protected function start($queue)
    {
        $queue instanceof \Iterator ? $queue->rewind() : reset($queue);
        return $queue;
    }

    /**
     * @param array|\Iterator $queue
     * @return array|\Iterator
     */
    protected function step($queue)
    {
        $queue instanceof \Iterator ? $queue->next() : next($queue);
        return $queue;
    }

    /**
     * @param Event|mixed $event
     * @param array|\Iterator $queue
     * @return bool
     */
    protected function stopped($event, $queue) : bool
    {
        return ($event instanceof Event && $event->stopped()) ||
            ($queue instanceof \Iterator ? !$queue->valid() : null === key($queue));
    }
}
