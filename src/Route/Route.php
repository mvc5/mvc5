<?php
/**
 *
 */

namespace Mvc5\Route;

use Mvc5\Config\Immutable;

interface Route
    extends Immutable
{
    /**
     * @param $name
     * @return mixed
     */
    function action($name = null);

    /**
     * @param string $name
     * @return self
     */
    function child($name);

    /**
     * @return self[]
     */
    function children();

    /**
     * @return array
     */
    function constraints();

    /**
     * @return array|callable|object|string
     */
    function controller();

    /**
     * @return array
     */
    function defaults();

    /**
     * @return null|string|string[]
     */
    function host();

    /**
     * @return null|string|string[]
     */
    function method();

    /**
     * @return string
     */
    function name();

    /**
     * @return array
     */
    function options();

    /**
     * @return int|null|string
     */
    function port();

    /**
     * @return string
     */
    function regex();

    /**
     * @return string
     */
    function route();

    /**
     * @return null|string|string[]
     */
    function scheme();

    /**
     * @return array
     */
    function tokens();

    /**
     * @return bool
     */
    function wildcard();
}
