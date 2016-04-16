<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Config\Configuration;
use Mvc5\Plugins as _Plugins;
use Mvc5\Resolvable;
use Mvc5\Service\Service as _Service;

class Provider
    extends Call
{
    /**
     * Creates an object with a Plugins container and sets the object as the scope of the anonymous functions. If the
     * object is cloned, it will need a clone method to workaround the recursion problem.
     *
     * @param string $name
     * @param array|Configuration|Resolvable $config
     */
    public function __construct($name, $config = [])
    {
        parent::__construct([$this, 'provider'], [new Link, new Plugin(_Plugins::class, [$config, new Link]), $name]);
    }

    /**
     * @param _Service $service
     * @param _Plugins $plugins
     * @param string $name
     * @return callable|null|object
     */
    public function provider(_Service $service, _Plugins $plugins, $name)
    {
        $plugin = $service->plugin($name, [$plugins]);

        $plugins->scope($plugin);

        return $plugin;
    }
}
