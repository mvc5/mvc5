<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

use Mvc5\Config\Configuration;
use Mvc5\Resolvable;

interface Plugin
    extends Configuration, Resolvable
{
    /**
     * @return array
     */
    function args();

    /**
     * @return array
     */
    function calls();

    /**
     * @return bool
     */
    function merge();

    /**
     * @return Plugin|string
     */
    function name();

    /**
     * @return string
     */
    function param();
}
