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
     * @param $name
     * @param null $config
     */
    function __construct($name, $config = null)
    {
        $this->config = $config;
        $this->name   = $name;
    }
}
