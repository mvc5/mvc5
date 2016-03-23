<?php
/**
 *
 */

namespace Mvc5\Event;

use Mvc5\Signal as _Signal;
use Traversable;

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
     * @param array|object|string|Traversable $event
     * @param array $args
     * @param callable $callback
     * @return mixed|null
     */
    protected function generate($event, array $args = [], callable $callback = null)
    {
        $result = null;

        foreach($this->queue($event, $args) as $listener) {

            $result = $this->emit($event, $this->callable($listener), $args, $callback);

            if ($event instanceof Event && $event->stopped()) {
                break;
            }
        }

        return $result;
    }

    /**
     * @param array|Event|object|string|Traversable $event
     * @param array $args
     * @return array|Traversable
     */
    protected function queue($event, array $args = [])
    {
        return is_array($event) || $event instanceof Traversable ? $event : $this->traversable($event, $args);
    }

    /**
     * @param Event|object|string $event
     * @param array $args
     * @return array|Traversable|null
     */
    protected abstract function traversable($event, array $args = []);
}
