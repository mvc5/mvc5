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
     * @var array|\ArrayAccess
     */
    protected $events = [];

    /**
     * @param array|\Iterator|object|string $event
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     */
    protected function event($event, array $args = [], callable $callback = null)
    {
        return $this->generate($event, $args, $callback ?? $this);
    }

    /**
     * @param Event|object|string $event
     * @return string
     */
    protected function eventName($event) : string
    {
        return is_string($event) ? $event : ($event instanceof Event ? $event->name() : get_class($event));
    }

    /**
     * @return array|\ArrayAccess
     */
    function events()
    {
        return $this->events;
    }

    /**
     * @param Event|object|string $event
     * @param array $args
     * @return array|\Iterator|null
     */
    protected function iterator($event, array $args = [])
    {
        return $this->resolve($this->listeners($this->eventName($event)), $args);
    }

    /**
     * @param Event|mixed $plugin
     * @return callable|null
     */
    protected function listener($plugin)
    {
        return !$plugin instanceof Event ? $plugin : function(...$argv) use ($plugin) {
            return $this->event($plugin, $this->variadic($argv));
        };
    }

    /**
     * @param string $name
     * @return array|\Iterator
     */
    protected function listeners(string $name)
    {
        return $this->events[$name] ?? Unresolvable::plugin($name);
    }

    /**
     * @param array|\Iterator|Event|object|string $event
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     */
    function trigger($event, array $args = [], callable $callback = null)
    {
        return $this->event($event instanceof Event ? $event : $this($event) ?? $event, $args, $callback);
    }

    /**
     * @param string|mixed $plugin
     * @param array $args
     * @return mixed
     */
    abstract function __invoke($plugin, array $args = []);
}
