<?php
/**
 *
 */

namespace Mvc5\Service\Resolver\Event;

use Mvc5\Event\Event;

class Create
    implements Creator
{
    /**
     * @var callable
     */
    protected $callback;

    /**
     * @var array|\ArrayAccess
     */
    protected $events;

    /**
     * @param array|\ArrayAccess $events
     * @param callable $callback
     */
    public function __construct($events, callable $callback = null)
    {
        $this->callback = $callback;
        $this->events   = $events;
    }

    /**
     * @param string $service
     * @return Dispatch|Event
     */
    public function __invoke($service)
    {
        return !isset($this->events[$service])
            ? null : ($this->callback ? call_user_func_array($this->callback, [$service]) : new Dispatch($service));
    }
}
