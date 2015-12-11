<?php
/**
 *
 */

namespace Mvc5\Route;

use Mvc5\Config\Configuration;

interface Route
    extends Configuration
{
    /**
     * @return array|callable|null|object|string
     */
    function controller();

    /**
     * @return string|string[]
     */
    function hostname();

    /**
     * @return int
     */
    function length();

    /**
     * @return bool
     */
    function matched();

    /**
     * @return string|string[]
     */
    function method();

    /**
     * @return string
     */
    function name();

    /**
     * @return array
     */
    function params();

    /**
     * @return string
     */
    function path();

    /**
     * @return string|string[]
     */
    function scheme();
}
