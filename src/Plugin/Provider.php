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
    const PLUGINS_CLASS = 'Mvc5\Plugins';

    /**
     * @param string $name
     * @param array|Configuration|Resolvable $config
     * @param ...array $args
     */
    public function __construct($name, $config = [], ...$args)
    {
        parent::__construct(
            [$this, 'provider'], [new Link, new Plugin(static::PLUGINS_CLASS, [$config, new Link]), $name, new Args($args)]
        );
    }

    /**
     * @param _Service $service
     * @param Scope $plugins
     * @param string $name
     * @param array $args
     * @return callable|null|object
     */
    public function provider(_Service $service, Scope $plugins, $name, array $args = [])
    {
        array_unshift($args, $plugins);

        $plugin = $service->plugin($name, $args);

        $plugins->scope($plugin);

        return $plugin;
    }
}
