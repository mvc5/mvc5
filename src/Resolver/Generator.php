<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Mvc5\Event\Event;
use Mvc5\Event\Generator as EventGenerator;

trait Generator
{
    /**
     *
     */
    use EventGenerator;

    /**
     * @var array|mixed
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
        return is_string($event) ? $event : ($event instanceof Event ? $event->name() : get_class($event));
    }

    /**
     * @return array|mixed
     */
    function events()
    {
        return $this->events;
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
     * @param $plugin
     * @return callable|null
     */
    protected function listener($plugin)
    {
        return !$plugin instanceof Event ? $plugin : function(...$args) use ($plugin) {
            return $this->event($plugin, $this->variadic($args));
        };
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
     * @param array|object|string|\Traversable $event
     * @param array $args
     * @param callable $callback
     * @return mixed|null
     */
    function trigger($event, array $args = [], callable $callback = null)
    {
        return $this->event($event instanceof Event ? $event : $this($event) ?? $event, $args, $callback);
    }

    /**
     * @param string $name
     * @param array $args
     * @return array|callable|null|object|string
     */
    abstract function __invoke($name, array $args = []);
}
