<?php
/**
 *
 */

namespace Mvc5\Request\Error;

use Mvc5\Model\ViewModel as Base;

interface ViewModel
    extends Base
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
