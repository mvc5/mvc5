<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

use Mvc5\Resolvable;

interface Dependency
    extends Resolvable
{
    /**
     * @return string
     */
    function name();

    /**
     * @return string
     */
    function config();
}
