<?php
/**
 *
 */

namespace Mvc5\Route\Config;

use Mvc5\Arg;
use Mvc5\Request\Request as Mvc5Request;
use Mvc5\Request\Config\Request as Config;

trait Request
{
    /**
     *
     */
    use Config;

    /**
     * @return int
     */
    function length()
    {
        return $this[Arg::LENGTH] ?: 0;
    }

    /**
     * @return bool
     */
    function matched()
    {
        return $this[Arg::MATCHED] ?: false;
    }

    /**
     * @return Mvc5Request
     */
    function request()
    {
        return $this->config;
    }
}
