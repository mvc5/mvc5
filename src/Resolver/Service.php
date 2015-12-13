<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Mvc5\Arg;
use Mvc5\Event\Event;
use Mvc5\Plugin;

class Service
{
    /**
     *
     */
    use Plugin;

    /**
     * @var array|\ArrayAccess
     */
    protected $events;

    /**
     * @param array|\ArrayAccess $events
     */
    public function __construct($events)
    {
        $this->events = $events;
    }

    /**
     * @param string $name
     * @return Event|null
     */
    public function __invoke($name)
    {
        return !isset($this->events[$name]) ? null : $this->plugin(Arg::EVENT_MODEL, [Arg::EVENT => $name]);
    }
}
