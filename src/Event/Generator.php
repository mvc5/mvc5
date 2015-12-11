<?php
/**
 *
 */

namespace Mvc5\Event;

use Traversable;

trait Generator
{
    /**
     * @var array|Traversable
     */
    protected $events = [];

    /**
     * @param callable|Event|string $event
     * @param callable $listener
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    protected function emit($event, callable $listener, array $args = [], callable $callback = null)
    {
        return is_callable($event) ? $event($listener, $args, $callback) : $this->invoke($listener, $args, $callback);
    }

    /**
     * @param array|\ArrayAccess|null|Traversable $config
     * @return array|\ArrayAccess|null|Traversable
     */
    public function events($config = null)
    {
        return null !== $config ? $this->events = $config : $this->events;
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

        foreach($this->queue($event) as $listener) {

            $result = $this->emit($event, $this->invokable($listener), $args, $callback);

            if ($event instanceof Event && $event->stopped()) {
                break;
            }
        }

        return $result;
    }

    /**
     * @param array|callable|object|string $config
     * @return callable|null
     */
    protected abstract function invokable($config) : callable;

    /**
     * @param array|callable|object|string $config
     * @param array $args
     * @param callable $callback
     * @return array|callable|object|string
     */
    protected abstract function invoke($config, array $args = [], callable $callback = null);

    /**
     * @param string $name
     * @return array|Traversable|null
     */
    protected function listeners($name)
    {
        return $this->events[$name] ?? null;
    }

    /**
     * @param array|Event|string|Traversable $event
     * @return array|Traversable
     */
    protected function queue($event)
    {
        return is_array($event) || $event instanceof Traversable ? $event : $this->listeners(
            is_string($event) ? $event : ($event instanceof Event ? $event->event() : get_class($event))
        );
    }
}
