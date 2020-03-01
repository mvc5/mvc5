<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

use Closure;

interface Scoped
    extends Gem
{
    /**
     * @return Closure
     */
    function closure() : Closure;

    /**
     * @return bool|true
     */
    function scoped() : bool;
}
