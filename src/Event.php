<?php
/**
 *
 */

namespace Mvc5;

class Event
    implements Event\Event
{
    /**
     *
     */
    use Event\Signal;

    /**
     * @param string|null $event
     */
    public function __construct($event = null)
    {
        $this->event = $event;
    }
}
