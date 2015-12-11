<?php
/**
 *
 */

namespace Mvc5\Plugin;

class Dependency
    implements Gem\Dependency
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var
     */
    protected $config;

    /**
     * @param $name
     * @param null $config
     */
    public function __construct($name, $config = null)
    {
        $this->config = $config;
        $this->name   = $name;
    }

    /**
     * @return string
     */
    public function config()
    {
        return $this->config;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }
}
