<?php
/**
 *
 */

namespace Mvc5\Request\Error\Config;

use Mvc5\View\Config\ViewModel;

use const Mvc5\{ CODE, ERROR, ERRORS, MESSAGE };

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
        return $this[ERROR][CODE];
    }

    /**
     * @return array
     */
    function errors() : array
    {
        return $this[ERROR][ERRORS] ?? [];
    }

    /**
     * @return string|null
     */
    function message() : ?string
    {
        return $this[ERROR][MESSAGE];
    }
}
