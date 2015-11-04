<?php
/**
 *
 */

namespace Mvc5\Event\Manager;

use Mvc5\Event\Event;

trait ManageEvent
{
    /**
     * @var array|\Traversable
     */
    protected $events;

    /**
     * @param array|Event|string $event
     * @return Event|string
     */
    protected abstract function event($event);

    /**
     * @param array|\Traversable $events
     */
    public function events($events)
    {
        $this->events = $events;
    }

    /**
     * @param Event|string $event
     * @param array $args
     * @param callable $callback
     * @return mixed|null
     */
    protected abstract function generate($event, array $args = [], callable $callback = null);

    /**
     * @return array|\Traversable
     */
    protected function listeners()
    {
        return $this->events;
    }

    /**
     * @param array|Event|string $event
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    public function trigger($event, array $args = [], callable $callback = null)
    {
        return $this->generate($this->event($event), $args, $callback);
    }
}
