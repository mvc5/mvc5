<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;
use Mvc5\Session\Config as SessionConfig;
use Mvc5\Session\Container as SessionContainer;

class Session
    extends Dependency
{
    /**
     *
     */
    function __construct()
    {
        parent::__construct(Arg::SESSION, new End(
            new Call('session\start'), new Plugin(SessionContainer::class, [new Plugin(SessionConfig::class)])
        ));
    }
}
