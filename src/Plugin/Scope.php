<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Config\Scope as _Scope;
use Mvc5\Service\Service as _Service;

/**
 * Creates an object with a Plugins container and sets the object as the scope of the anonymous functions. If the
 * object is cloned, it will need a clone method to workaround the recursion problem.
 */
class Scope
    extends Call
{
    /**
     *
     */
    const APP_CLASS = 'Mvc5\App';

    /**
     * @param $name
     * @param array $config
     * @param array ...$args
     */
    function __construct($name, $config = [], ...$args)
    {
        parent::__construct([$this, 'scope'], [new Link, $this->plugins($config), $name, new Args($args)]);
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
     * @param _Scope $plugins
     * @param string $name
     * @param array $args
     * @return callable|null|object
     */
    function scope(_Service $service, _Scope $plugins, $name, array $args = [])
    {
        array_unshift($args, $plugins);

        $plugin = $service->plugin($name, $args);

        $plugins->scope($plugin);

        return $plugin;
    }
}
