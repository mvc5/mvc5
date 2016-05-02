<?php
/**
 *
 */

namespace Mvc5\Route\Config;

use Mvc5\Arg;
use Mvc5\Config\Config as Base;

trait Definition
{
    /**
     *
     */
    use Base;

    /**
     * @param $name
     * @param array|Definition $definition
     * @return void
     */
    function add($name, $definition)
    {
        $this->config[Arg::CHILDREN][$name] = $definition;
    }

    /**
     * @param $name
     * @return mixed
     */
    function action($name)
    {
        return $this[Arg::ACTION][$name] ?? null;
    }

    /**
     * @return array
     */
    function actions()
    {
        return $this[Arg::ACTION] ?? [];
    }

    /**
     * @param string $name
     * @return self
     */
    function child($name)
    {
        return $this[Arg::CHILDREN][$name] ?? null;
    }

    /**
     * @return self[]
     */
    function children()
    {
        return $this[Arg::CHILDREN] ?? [];
    }

    /**
     * @return null|string
     */
    function className()
    {
        return $this[Arg::CLASS_NAME];
    }

    /**
     * @return array
     */
    function constraints()
    {
        return $this[Arg::CONSTRAINTS] ?? [];
    }

    /**
     * @return array|callable|object|string
     */
    function controller()
    {
        return $this[Arg::CONTROLLER];
    }

    /**
     * @return array
     */
    function defaults()
    {
        return $this[Arg::DEFAULTS] ?? [];
    }

    /**
     * @return null|string|string[]
     */
    function hostname()
    {
        return $this[Arg::HOSTNAME] ?? null;
    }

    /**
     * @return array
     */
    function method()
    {
        return $this[Arg::METHOD] ?? null;
    }

    /**
     * @return string
     */
    function name()
    {
        return $this[Arg::NAME];
    }

    /**
     * @return array
     */
    function paramMap()
    {
        return $this[Arg::PARAM_MAP] ?? [];
    }

    /**
     * @return int|null|string
     */
    function port()
    {
        return $this[Arg::PORT];
    }

    /**
     * @return string
     */
    function regex()
    {
        return $this[Arg::REGEX];
    }

    /**
     * @return string
     */
    function route()
    {
        return $this[Arg::ROUTE];
    }

    /**
     * @return null|string|string[]
     */
    function scheme()
    {
        return $this[Arg::SCHEME];
    }

    /**
     * @return array
     */
    function tokens()
    {
        return $this[Arg::TOKENS] ?? [];
    }

    /**
     * @return bool
     */
    function wildcard()
    {
        return $this[Arg::WILDCARD] ?? false;
    }
}
