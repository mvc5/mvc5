<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

use Mvc5\Resolvable;

interface Param
    extends Resolvable
{
    /**
     * @return string
     */
    function name();
}
