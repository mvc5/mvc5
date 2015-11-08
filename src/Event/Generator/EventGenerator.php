<?php
/**
 *
 */

namespace Mvc5\Event\Generator;

use Mvc5\Config\Configuration;
use Mvc5\Event\Event;
use Traversable;

trait EventGenerator
{
    /**
     * @param callable|Event|string|Traversable $event
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
     * @param Event|string|Traversable $event
     * @param array $args
     * @param callable $callback
     * @return mixed|null
     */
    protected function generate($event, array $args = [], callable $callback = null)
    {
        $result = null;

        foreach($this->queue($event) as $listener) {

            $result = $this->emit($event, $this->listener($listener), $args, $callback);

            if ($event instanceof Event && $event->stopped()) {
                break;
            }
        }

        return $result;
    }

    /**
     * @param $listener
     * @return callable
     */
    protected abstract function listener($listener);

    /**
     * @param string $name
     * @return Configuration
     */
    protected abstract function listeners($name = null);

    /**
     * @param Event|string|Traversable $event
     * @return array|Traversable
     */
    protected function queue($event)
    {
        return $event instanceof Traversable ? $event : $this->listeners(
            is_string($event) ? $event : ($event instanceof Event ? $event->event() : get_class($event))
        );
    }

    /**
     * @param callable $listener
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    protected abstract function signal(callable $listener, array $args = [], callable $callback = null);
}
