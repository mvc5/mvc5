<?php
/**
 *
 */

namespace Mvc5\Plugin\Config;

trait Config
{
    /**
     * @var mixed
     */
    protected $config;

    /**
     * @param $config
     */
    function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    function config()
    {
        return $this->config;
    }
}
