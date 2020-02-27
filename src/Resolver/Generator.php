<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Iterator;
use Mvc5\Event\Event;
use Mvc5\Event\Generator as EventGenerator;
use Mvc5\Iterator as Mvc5Iterator;
use Throwable;

use function is_string;
use function get_class;

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
     * @param array|Iterator|object|string $event
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     * @throws Throwable
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
     * @return Iterator
     * @throws Throwable
     */
    protected function iterator($event, array $args = []) : Iterator
    {
        return is_array($event) ? new Mvc5Iterator($event) : ($event instanceof Iterator ? $event
            : $this->listeners($this->eventName($event), $args));
    }

    /**
     * @param Event|mixed $plugin
     * @return callable|null
     */
    protected function listener($plugin)
    {
        return !$plugin instanceof Event ? $plugin : fn(...$argv) => $this->event($plugin, $this->variadic($argv));
    }

    /**
     * @param string $name
     * @param array $args
     * @return Iterator
     * @throws Throwable
     */
    protected function listeners(string $name, array $args = []) : Iterator
    {
        return iterator($this->resolve($this->events[$name] ?? Unresolvable::plugin($name), $args));
    }

    /**
     * @param array|Iterator|Event|object|string $event
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     * @throws Throwable
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

/**
 * @param $queue
 * @return Iterator
 */
function iterator($queue) : Iterator
{
    return is_array($queue) ? new Mvc5Iterator($queue) : $queue;
}
