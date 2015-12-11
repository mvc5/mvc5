<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

use Mvc5\Resolvable;

interface Invokable
    extends Resolvable
{
    /**
     * @return array
     */
    function args();

    /**
     * @return array|callable|object|Plugin|string
     */
    function config();
}
