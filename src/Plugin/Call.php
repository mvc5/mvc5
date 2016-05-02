<?php
/**
 *
 */

namespace Mvc5\Plugin;

class Call
    implements Gem\Call
{
    /**
     *
     */
    use Config\Args;
    use Config\Config;

    /**
     * @param $config
     * @param array $args
     */
    function __construct($config, array $args = [])
    {
        $this->args   = $args;
        $this->config = $config;
    }
}
