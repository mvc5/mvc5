<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Service\Manager;
use Mvc5\Service\Service;

/**
 * Creates an object with a Plugins container and sets the object as the scope of the anonymous functions. If the
 * object is cloned, it will need a clone method to workaround the recursion problem.
 */
class Scope
    extends Call
{
    /**
     * @param Manager $context
     * @param string $name
     */
    function __construct(Manager $context, string $name)
    {
        parent::__construct([$this, 'scope'], [$context, new Link, $name]);
    }

    /**
     * @param Manager $context
     * @param Service $service
     * @param string $name
     * @return callable|object|null
     */
    function scope(Manager $context, Service $service, string $name)
    {
        return $context->plugin(new ScopedCall(fn() => fn() => $this->scope = $service->plugin($name, [$this, $service])));
    }
}
