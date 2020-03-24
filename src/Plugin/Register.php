<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Service\Service;

use const Mvc5\{ NAME, PLUGIN, SERVICE };

class Register
    extends Call
{
    /**
     * @param string $name
     * @param mixed $service
     * @param mixed $plugin
     */
    function __construct(string $name, $service, $plugin = null)
    {
        parent::__construct(
            [$this, 'register'], [new Link, [NAME => $name, SERVICE => $service, PLUGIN => $plugin]]
        );
    }

    /**
     * @param Service $plugins
     * @param array $config
     * @return callable|object|null
     */
    function register(Service $plugins, array $config)
    {
        $service = $plugins->plugin($config[SERVICE]);

        return $service[$config[NAME]] ?? (
            isset($config[PLUGIN]) ? $service[$config[NAME]] = $plugins->plugin($config[PLUGIN]) : null
        );
    }
}
