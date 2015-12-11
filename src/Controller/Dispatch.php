<?php
/**
 *
 */

namespace Mvc5\Controller;

use Mvc5\Arg;
use Mvc5\Event\Event;
use Mvc5\Event\Signal;

class Dispatch
    implements Event
{
    /**
     *
     */
    use Signal;

    /**
     *
     */
    const EVENT = Arg::CONTROLLER_DISPATCH;
}
