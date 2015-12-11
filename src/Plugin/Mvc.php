<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;
use Mvc5\Mvc as MvcEvent;

class Mvc
    implements Gem\Plugin
{
    /**
     *
     */
    use Config\Plugin;

    /**
     * @param $event
     */
    public function __construct($event)
    {
        $this->config = [
            Arg::ARGS  => [Arg::EVENT => $event, Arg::CONFIG => new Link],
            Arg::NAME  => MvcEvent::class
        ];
    }
}
