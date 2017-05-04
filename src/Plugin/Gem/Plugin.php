<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

use Mvc5\Config\Model;

interface Plugin
    extends Gem, Model
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
