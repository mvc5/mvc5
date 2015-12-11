<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

use Mvc5\Resolvable;

interface Plug
    extends Resolvable
{
    /**
     * @return string
     */
    function name();
}
