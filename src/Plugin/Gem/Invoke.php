<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

use Mvc5\Resolvable;

interface Invoke
    extends Resolvable
{
    /**
     * @return array
     */
    function args();

    /**
     * @return string|array
     */
    function config();
}
