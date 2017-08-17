<?php
/**
 *
 */

namespace Mvc5\Event;

use Mvc5\Signal;

trait Generator
{
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
        return $event instanceof Event ? $event($listener, $args, $callback) : $this->signal($listener, $args, $callback);
    }

    /**
     * @param array|string|\Iterator $event
     * @param array $args
     * @param callable $callback
     * @return mixed|null
     */
    protected function generate($event, array $args = [], callable $callback = null)
    {
        return $this->traverse($event, $this->queue($event, $args), $args, $callback);
    }

    /**
     * @param $event
     * @param $queue
     * @param $args
     * @param $callback
     * @param $result
     * @param $current
     * @return null
     */
    protected function iterate($event, $queue, $args, $callback, $result, callable $current)
    {
        return $this->stopped($event, $queue) ? $result : $this->loop(
            $event, $queue, $args, $callback, $this->result($event, $current($queue), $args, $callback, $result)
        );
    }

    /**
     * @param $event
     * @param $queue
     * @param $args
     * @param $callback
     * @param $result
     * @return null
     */
    protected function loop($event, &$queue, $args, $callback, $result)
    {
        return $this->iterate($event, $queue, $args, $callback, $result, function(&$queue) {
            if ($queue instanceof \Iterator) {
                $queue->next();
                return $queue->current();
            }

            return next($queue);
        });
    }

    /**
     * @param array|Event|object|string|\Iterator $event
     * @param array $args
     * @return array|\Iterator
     */
    protected function queue($event, array $args = [])
    {
        return is_array($event) || $event instanceof \Iterator ? $event : $this->iterator($event, $args);
    }

    /**
     * @param array|Event|object|\Iterator $event
     * @param $listener
     * @param array $args
     * @param callable $callback
     * @param $result
     * @return mixed
     */
    protected function result($event, $listener, array $args = [], callable $callback = null, $result = null)
    {
        return !$listener ? $result : $this->emit($event, $this->callable($listener), $args, $callback);
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
     * @return mixed|null
     */
    protected function start(&$queue)
    {
        $queue instanceof \Iterator ? $queue->rewind() : reset($queue);
        return $queue;
    }

    /**
     * @param $event
     * @param array|\Iterator $queue
     * @return bool
     */
    protected function stopped($event, $queue)
    {
        return ($event instanceof Event && $event->stopped()) ||
            ($queue instanceof \Iterator ? !$queue->valid() : null === key($queue));
    }

    /**
     * @param $event
     * @param $queue
     * @param $args
     * @param $callback
     * @return null
     */
    protected function traverse($event, $queue, $args, $callback)
    {
        return $this->iterate($event, $this->start($queue), $args, $callback, null, function(&$queue) {
            return $queue instanceof \Iterator ? $queue->current() : current($queue);
        });
    }
}
