<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

interface Filter
    extends Gem
{
    /**
     * @return array
     */
    function args();

    /**
     * @return Plugin|string
     */
    function config();

    /**
     * @return string|array
     */
    function filter();

    /**
     * @return string
     */
    function param();
}
