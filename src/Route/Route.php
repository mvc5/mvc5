<?php
/**
 *
 */

namespace Mvc5\Route;

use Mvc5\Config\Configuration;
use Mvc5\Response\Error;

interface Route
    extends Configuration
{
    /**
     * @return array|callable|null|object|string
     */
    function controller();

    /**
     * @return Error
     */
    function error();

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
     * @param $name
     * @return mixed
     */
    function param($name);

    /**
     * @return array
     */
    function params();

    /**
     * @return string
     */
    function path();

    /**
     * @return int|null|string
     */
    function port();

    /**
     * @return string|string[]
     */
    function scheme();
}
