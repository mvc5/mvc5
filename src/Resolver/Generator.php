<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Mvc5\Event\Event;
use Mvc5\Event\Generator as _Generator;

trait Generator
{
    /**
     *
     */
    use _Generator;

    /**
     * @var array|\ArrayAccess
     */
    protected $events = [];

    /**
     * @param array|object|string|\Traversable $event
     * @param array $args
     * @param callable $callback
     * @return mixed|null
     */
    protected function event($event, array $args = [], callable $callback = null)
    {
        return $this->generate($event, $args, $callback ?? $this);
    }

    /**
     * @param $event
     * @return string
     */
    protected function eventName($event)
    {
        return is_string($event) ? $event : ($event instanceof Event ? $event->event() : get_class($event));
    }

    /**
     * @param array|\ArrayAccess|null $config
     * @return array|\ArrayAccess|null
     */
    function events($config = null)
    {
        return null !== $config ? $this->events = $config : $this->events;
    }

    /**
     * @param Event|object|string $event
     * @param array $args
     * @return array|\Traversable|null
     */
    protected function iterator($event, array $args = [])
    {
        return $this->resolve($this->listeners($this->eventName($event)), $args);
    }

    /**
     * @param string $name
     * @return array|\Traversable|null
     */
    protected function listeners($name)
    {
        return $this->events[$name] ?? Unresolvable::plugin($name);
    }

    /**
     * @param $config
     * @param array $args
     * @return array|callable|null|object|string
     */
    protected abstract function resolve($config, array $args = []);
}
