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
     * @param string $name
     * @return self
     */
    public function child($name)
    {
        return $this->config[Arg::CHILDREN][$name] ?? null;
    }

    /**
     * @return self[]
     */
    public function children()
    {
        return $this->get(Arg::CHILDREN) ?: [];
    }

    /**
     * @return null|string
     */
    public function className()
    {
        return $this->get(Arg::CLASS_NAME);
    }

    /**
     * @return array
     */
    public function constraints()
    {
        return $this->get(Arg::CONSTRAINTS) ?: [];
    }

    /**
     * @return array|callable|object|string
     */
    public function controller()
    {
        return $this->get(Arg::CONTROLLER);
    }

    /**
     * @return array
     */
    public function defaults()
    {
        return $this->get(Arg::DEFAULTS) ?: [];
    }

    /**
     * @return null|string|string[]
     */
    public function hostname()
    {
        return $this->get(Arg::HOSTNAME) ?: null;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->get(Arg::NAME);
    }

    /**
     * @return null|string|string[]
     */
    public function method()
    {
        return $this->get(Arg::METHOD) ?: null;
    }

    /**
     * @return array
     */
    public function paramMap()
    {
        return $this->get(Arg::PARAM_MAP) ?: [];
    }

    /**
     * @return string
     */
    public function regex()
    {
        return $this->get(Arg::REGEX);
    }

    /**
     * @return string
     */
    public function route()
    {
        return $this->get(Arg::ROUTE);
    }

    /**
     * @return null|string|string[]
     */
    public function scheme()
    {
        return $this->get(Arg::SCHEME);
    }

    /**
     * @return array
     */
    public function tokens()
    {
        return $this->get(Arg::TOKENS) ?: [];
    }

    /**
     * @return bool
     */
    public function wildcard()
    {
        return $this->get(Arg::WILDCARD) ?: false;
    }
}
