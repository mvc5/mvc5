<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

use Mvc5\Resolvable;

interface Call
    extends Resolvable
{
    /**
     * @return array
     */
    function args();

    /**
     * @return string
     */
    function config();
}
