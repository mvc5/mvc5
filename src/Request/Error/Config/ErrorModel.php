<?php
/**
 *
 */

namespace Mvc5\Request\Error\Config;

use Mvc5\Arg;
use Mvc5\View\Config\ViewModel;

trait ErrorModel
{
    /**
     *
     */
    use ViewModel;

    /**
     * @return int|null
     */
    function code() : ?int
    {
        return $this[Arg::ERROR][Arg::CODE];
    }

    /**
     * @return array
     */
    function errors() : array
    {
        return $this[Arg::ERROR][Arg::ERRORS] ?? [];
    }

    /**
     * @return string|null
     */
    function message() : ?string
    {
        return $this[Arg::ERROR][Arg::MESSAGE];
    }
}
