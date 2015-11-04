<?php
/**
 *
 */

namespace Mvc5\Service\Resolver\Event;

use Mvc5\Event\Event;
use Mvc5\Service\Resolver\EventSignal;

class Dispatch
    implements Dispatcher, Event
{
    /**
     *
     */
    use EventSignal;

    /**
     * @param string $event
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * @return array
     */
    protected function args()
    {
        return [
            Args::EVENT => $this
        ];
    }
}
