<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;
use Mvc5\Resolvable;
use Mvc5\Service\Service as _Service;

class Register
    extends Call
{
    /**
     * @param string $name
     * @param string $service
     * @param mixed|null|Resolvable $plugin
     */
    function __construct($name, $service, $plugin = null)
    {
        parent::__construct(
            [$this, 'register'], [new Link, [Arg::NAME => $name, Arg::SERVICE => $service, Arg::PLUGIN => $plugin]]
        );
    }

    /**
     * @param _Service $plugins
     * @param array $config
     * @return callable|null|object
     */
    function register(_Service $plugins, array $config)
    {
        $service = $plugins->plugin($config[Arg::SERVICE]);

        if (isset($service[$config[Arg::NAME]])) {
            return $service[$config[Arg::NAME]];
        }

        return isset($config[Arg::PLUGIN]) ?
            $service[$config[Arg::NAME]] = $plugins->plugin($config[Arg::PLUGIN]) : null;
    }
}
