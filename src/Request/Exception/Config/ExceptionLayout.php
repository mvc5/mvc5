<?php
/**
 *
 */

namespace Mvc5\Request\Exception\Config;

use Mvc5\View\Config\ViewLayout;

use const Mvc5\EXCEPTION;

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
        return $this[EXCEPTION];
    }
}
