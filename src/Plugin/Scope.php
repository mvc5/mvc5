<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Service\Service;

/**
 * Creates an object with a Plugins container and sets the object as the scope of the anonymous functions. If the
 * object is cloned, it will need a clone method to workaround the recursion problem.
 */
class Scope
    extends Call
{
    /**
     * @param string $name
     * @param array $args
     */
    function __construct(string $name, array $args)
    {
        parent::__construct([$this, 'scope'], [$name, new Link, new Args($args)]);
    }

    /**
     * @param string $name
     * @param Service $service
     * @param array $args
     * @return callable|null|object
     */
    function scope(string $name, Service $service, array $args)
    {
        $plugin = $service->plugin($name, $args);

        $args[0]->scope($plugin);

        return $plugin;
    }
}
