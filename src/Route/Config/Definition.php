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
    public function add($name, $definition)
    {
        $this->config[Arg::CHILDREN][$name] = $definition;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function action($name)
    {
        return $this[Arg::ACTION][$name] ?? null;
    }

    /**
     * @return array
     */
    public function actions()
    {
        return $this[Arg::ACTION] ?? [];
    }

    /**
     * @param string $name
     * @return self
     */
    public function child($name)
    {
        return $this[Arg::CHILDREN][$name] ?? null;
    }

    /**
     * @return self[]
     */
    public function children()
    {
        return $this[Arg::CHILDREN] ?? [];
    }

    /**
     * @return null|string
     */
    public function className()
    {
        return $this[Arg::CLASS_NAME];
    }

    /**
     * @return array
     */
    public function constraints()
    {
        return $this[Arg::CONSTRAINTS] ?? [];
    }

    /**
     * @return array|callable|object|string
     */
    public function controller()
    {
        return $this[Arg::CONTROLLER];
    }

    /**
     * @return array
     */
    public function defaults()
    {
        return $this[Arg::DEFAULTS] ?? [];
    }

    /**
     * @return null|string|string[]
     */
    public function hostname()
    {
        return $this[Arg::HOSTNAME] ?? null;
    }

    /**
     * @return array
     */
    public function method()
    {
        return $this[Arg::METHOD] ?? null;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this[Arg::NAME];
    }

    /**
     * @return array
     */
    public function paramMap()
    {
        return $this[Arg::PARAM_MAP] ?? [];
    }

    /**
     * @return string
     */
    public function regex()
    {
        return $this[Arg::REGEX];
    }

    /**
     * @return string
     */
    public function route()
    {
        return $this[Arg::ROUTE];
    }

    /**
     * @return null|string|string[]
     */
    public function scheme()
    {
        return $this[Arg::SCHEME];
    }

    /**
     * @return array
     */
    public function tokens()
    {
        return $this[Arg::TOKENS] ?? [];
    }

    /**
     * @return bool
     */
    public function wildcard()
    {
        return $this[Arg::WILDCARD] ?? false;
    }
}
