<?php
/**
 *
 */

namespace Mvc5\Plugin;

class Shared
    implements Gem\Shared
{
    /**
     *
     */
    use Config\Config;
    use Config\Name;

    /**
     * @param string $name
     * @param $config
     */
    function __construct(string $name, $config = null)
    {
        $this->config = $config;
        $this->name   = $name;
    }
}
