<?php
/**
 *
 */

namespace Mvc5\Config;

trait Base
{
    /**
     * @var array|Configuration
     */
    protected $config = [];

    /**
     * @param array $config
     */
    function __construct($config = [])
    {
        $this->config = $config;
    }
}
