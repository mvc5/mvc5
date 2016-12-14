<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Service\Service as _Service;

/**
 * Creates an object with a Plugins container and sets the object as the scope of the anonymous functions. If the
 * object is cloned, it will need a clone method to workaround the recursion problem.
 */
class Scope
    extends Call
{
    /**
     * @param $name
     * @param array $args
     */
    function __construct($name, array $args)
    {
        parent::__construct([$this, 'scope'], [$name, new Link, new Args($args)]);
    }

    /**
     * @param string $name
     * @param _Service $service
     * @param array $args
     * @return callable|null|object
     */
    function scope($name, _Service $service, array $args)
    {
        $plugin = $service->plugin($name, $args);

        $args[0]->scope($plugin);

        return $plugin;
    }
}
