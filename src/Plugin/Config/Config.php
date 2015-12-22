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
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function config()
    {
        return $this->config;
    }
}
