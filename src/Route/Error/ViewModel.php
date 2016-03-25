<?php
/**
 *
 */

namespace Mvc5\Route\Error;

use Mvc5\Model\ViewModel as Base;
use Mvc5\Route\Error;

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
