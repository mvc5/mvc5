<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

use Mvc5\Config\Base as Config;

trait Base
{
    /**
     *
     */
    use Config;

    /**
     * @param $name
     * @param array|Definition $definition
     * @return void
     */
    public function add($name, $definition)
    {
        $this->config[Definition::CHILDREN][$name] = $definition;
    }

    /**
     * @param string $name
     * @return self
     */
    public function child($name)
    {
        return isset($this->config[Definition::CHILDREN][$name]) ? $this->config[Definition::CHILDREN][$name] : null;
    }

    /**
     * @return self[]
     */
    public function children()
    {
        return $this->get(Definition::CHILDREN) ?: [];
    }

    /**
     * @return null|string
     */
    public function className()
    {
        return $this->get(Definition::CLASS_NAME);
    }

    /**
     * @return array
     */
    public function constraints()
    {
        return $this->get(Definition::CONSTRAINTS) ?: [];
    }

    /**
     * @return array|callable|object|string
     */
    public function controller()
    {
        return $this->get(Definition::CONTROLLER);
    }

    /**
     * @return array
     */
    public function defaults()
    {
        return $this->get(Definition::DEFAULTS) ?: [];
    }

    /**
     * @return null|string|string[]
     */
    public function hostname()
    {
        return $this->get(Definition::HOSTNAME) ?: null;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->get(Definition::NAME);
    }

    /**
     * @return null|string|string[]
     */
    public function method()
    {
        return $this->get(Definition::METHOD) ?: null;
    }

    /**
     * @return array
     */
    public function paramMap()
    {
        return $this->get(Definition::PARAM_MAP) ?: [];
    }

    /**
     * @return string
     */
    public function regex()
    {
        return $this->get(Definition::REGEX);
    }

    /**
     * @return string
     */
    public function route()
    {
        return $this->get(Definition::ROUTE);
    }

    /**
     * @return null|string|string[]
     */
    public function scheme()
    {
        return $this->get(Definition::SCHEME);
    }

    /**
     * @return array
     */
    public function tokens()
    {
        return $this->get(Definition::TOKENS) ?: [];
    }

    /**
     * @return bool
     */
    public function wildcard()
    {
        return $this->get(Definition::WILDCARD) ?: false;
    }
}
