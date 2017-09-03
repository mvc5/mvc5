<?php
/**
 *
 */

namespace Mvc5\Plugin;

class Invoke
    implements Gem\Invoke
{
    /**
     *
     */
    use Config\Args;
    use Config\Config;

    /**
     * @param mixed $config
     * @param array $args
     */
    function __construct($config, array $args = [])
    {
        $this->args   = $args;
        $this->config = $config;
    }
}
