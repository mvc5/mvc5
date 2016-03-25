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
     * @return string
     */
    function allow();

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
     * @param $name
     * @return array
     */
    function method($name);

    /**
     * @return array
     */
    function methods();

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
