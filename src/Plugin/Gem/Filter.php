<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

use Mvc5\Resolvable;

interface Filter
    extends Gem
{
    /**
     * @return array
     */
    function args() : array;

    /**
     * @return Plugin|string
     */
    function config();

    /**
     * @return string|null
     */
    function param() : ?string;

    /**
     * @return Resolvable
     */
    function plugin() : Resolvable;
}
