<?php
/**
 *
 */

namespace Mvc5\Request\Error;

interface ErrorModel
    extends \Mvc5\View\ViewModel
{
    /**
     * @return int|null
     */
    function code() : ?int;

    /**
     * @return array
     */
    function errors() : array;

    /**
     * @return string|null
     */
    function message() : ?string;
}
