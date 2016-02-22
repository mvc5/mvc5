<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

use Mvc5\Config\Configuration;

interface Plugin
    extends Configuration, Gem
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
