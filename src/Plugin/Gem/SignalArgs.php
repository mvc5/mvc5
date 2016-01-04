<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

use Mvc5\Resolvable;

interface SignalArgs
    extends Resolvable
{
    /**
     * @return array
     */
    function args();
}
