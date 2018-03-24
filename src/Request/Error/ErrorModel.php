<?php
/**
 *
 */

namespace Mvc5\Request\Error;

use Mvc5\View\ViewModel;

interface ErrorModel
    extends ViewModel
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
