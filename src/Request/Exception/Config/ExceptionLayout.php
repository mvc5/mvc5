<?php
/**
 *
 */

namespace Mvc5\Request\Exception\Config;

use Mvc5\Arg;
use Mvc5\View\Config\ViewLayout;

trait ExceptionLayout
{
    /**
     *
     */
    use ViewLayout;

    /**
     * @return \Throwable
     */
    function exception() : \Throwable
    {
        return $this[Arg::EXCEPTION];
    }
}
