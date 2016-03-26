<?php
/**
 *
 */

namespace Mvc5\Route;

use Mvc5\Config\Configuration;

interface Definition
    extends Configuration
{
    /**
     * @param $name
     * @param array|Definition $definition
     * @return void
     */
    function add($name, $definition);

    /**
     * @param $name
     * @return mixed
     */
    function action($name);

    /**
     * @return string[]
     */
    function actions();

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
     * @return null|string
     */
    function className();

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
    function hostname();

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
    function paramMap();

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
