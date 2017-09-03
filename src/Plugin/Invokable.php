<?php
/**
 *
 */

namespace Mvc5\Plugin;

class Invokable
    implements Gem\Invokable
{
    /**
     *
     */
    use Config\Args;
    use Config\Config;

    /**
     * @param callable|mixed $config
     * @param array $args
     */
    function __construct($config, array $args = [])
    {
        $this->args   = $args;
        $this->config = $config;
    }
}
