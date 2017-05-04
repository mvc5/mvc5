<?php
/**
 *
 */

namespace Mvc5\Route;

use Mvc5\Config\Model;

interface Route
    extends Model
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
     * @return array|string
     */
    function path();

    /**
     * @return int|null|string
     */
    function port();

    /**
     * @return string
     */
    function regex();

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
