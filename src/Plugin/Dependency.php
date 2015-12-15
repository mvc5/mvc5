<?php
/**
 *
 */

namespace Mvc5\Plugin;

class Dependency
    implements Gem\Dependency
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
    public function __construct($name, $config = null)
    {
        $this->config = $config;
        $this->name   = $name;
    }
}
