<?php
/**
 *
 */

namespace Mvc5\Config;

trait Base
{
    /**
     * @var array|Configuration|\Iterator|mixed
     */
    protected $config = [];

    /**
     * @param array|\Iterator|mixed $config
     */
    function __construct($config = [])
    {
        $this->config = $config;
    }
}
