<?php
/**
 *
 */

namespace Mvc5\Plugin\Config;

trait Config
{
    /**
     * @var string|mixed
     */
    protected $config;

    /**
     * @param string|mixed $config
     */
    function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @return string|mixed
     */
    function config()
    {
        return $this->config;
    }
}
