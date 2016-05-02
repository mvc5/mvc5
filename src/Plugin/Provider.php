<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Config\Configuration;
use Mvc5\Resolvable;
use Mvc5\Service\Service as _Service;
use Mvc5\Service\Scope;

/**
 * Creates an object with a Plugins container and sets the object as the scope of the anonymous functions. If the
 * object is cloned, it will need a clone method to workaround the recursion problem.
 */
class Provider
    extends Call
{
    /**
     *
     */
    const APP_CLASS = 'Mvc5\App';

    /**
     * @param string $name
     * @param array|Configuration|Resolvable $config
     * @param ...array $args
     */
    function __construct($name, $config = [], ...$args)
    {
        parent::__construct([$this, 'provider'], [new Link, $this->plugins($config), $name, new Args($args)]);
    }

    /**
     * @param $config
     * @return Plugin|Plugins
     */
    protected function plugins($config)
    {
        return $config instanceof Plugins || $config instanceof Plugin || $config instanceof Plug  ? $config :
            new Plugin(static::APP_CLASS, [$config, new Link]);
    }

    /**
     * @param _Service $service
     * @param Scope $plugins
     * @param string $name
     * @param array $args
     * @return callable|null|object
     */
    function provider(_Service $service, Scope $plugins, $name, array $args = [])
    {
        array_unshift($args, $plugins);

        $plugin = $service->plugin($name, $args);

        $plugins->scope($plugin);

        return $plugin;
    }
}
