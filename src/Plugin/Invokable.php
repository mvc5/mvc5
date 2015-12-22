<?php
/**
 *
 */

namespace Mvc5\Plugin;

class Invokable
    implements Gem\Invokable
{
    use Config\Args;
    use Config\Config;

    /**
     * @param $config
     * @param array $args
     */
    public function __construct($config, array $args = [])
    {
        $this->args   = $args;
        $this->config = $config;
    }
}
