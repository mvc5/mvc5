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
     * @return int
     */
    function code();

    /**
     * @return []
     */
    function errors();

    /**
     * @return string
     */
    function message();
}
