<?php
/**
 *
 */

namespace Mvc5\Request\Error\Config;

use Mvc5\Arg;
use Mvc5\View\Config\Model;

trait ErrorModel
{
    /**
     *
     */
    use Model;

    /**
     * @return int
     */
    function code()
    {
        return $this[Arg::ERROR][Arg::CODE];
    }

    /**
     * @return array
     */
    function errors()
    {
        return $this[Arg::ERROR][Arg::ERRORS];
    }

    /**
     * @return string
     */
    function message()
    {
        return $this[Arg::ERROR][Arg::MESSAGE];
    }
}
