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
    function args() : array;

    /**
     * @return array
     */
    function calls() : array;

    /**
     * @return bool
     */
    function merge() : bool;

    /**
     * @return Plugin|string
     */
    function name();

    /**
     * @return string|null
     */
    function param() : ?string;
}
