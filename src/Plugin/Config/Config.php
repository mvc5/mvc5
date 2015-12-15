<?php
/**
 *
 */

namespace Mvc5\Plugin\Config;

trait Config
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function config()
    {
        return $this->config;
    }
}
