<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

use Mvc5\Resolvable;

interface Args
    extends Resolvable
{
    /**
     * @return array
     */
    function config();
}
