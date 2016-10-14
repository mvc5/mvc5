<?php
/**
 *
 */

namespace Mvc5\Route\Config;

use Mvc5\Arg;
use Mvc5\Config\Config;

trait Route
{
    /**
     *
     */
    use Config;

    /**
     * @param $name
     * @param array|Route $route
     * @return void
     */
    function add($name, $route)
    {
        $this->config[Arg::CHILDREN][$name] = $route;
    }

    /**
     * @param $name
     * @return mixed
     */
    function action($name)
    {
        return $this->get(Arg::ACTION)[$name] ?? null;
    }

    /**
     * @return array
     */
    function actions()
    {
        return $this[Arg::ACTION] ?: [];
    }

    /**
     * @param string $name
     * @return self
     */
    function child($name)
    {
        return $this->get(Arg::CHILDREN)[$name] ?? null;
    }

    /**
     * @return self[]
     */
    function children()
    {
        return $this[Arg::CHILDREN] ?: [];
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
        return $this[Arg::CONSTRAINTS] ?: [];
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
        return $this[Arg::DEFAULTS] ?: [];
    }

    /**
     * @return null|string|string[]
     */
    function host()
    {
        return $this[Arg::HOST];
    }

    /**
     * @return array
     */
    function method()
    {
        return $this[Arg::METHOD];
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
    function options()
    {
        return $this[Arg::OPTIONS] ?: [];
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
        return $this[Arg::TOKENS] ?: [];
    }

    /**
     * @return bool
     */
    function wildcard()
    {
        return $this[Arg::WILDCARD] ?: false;
    }
}
