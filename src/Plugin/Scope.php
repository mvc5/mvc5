<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\App;
use Mvc5\Service\Manager;
use Mvc5\Service\Service;

use const Mvc5\SERVICES;

/**
 * Creates a model with a scopable plugins container and sets the model as the scope of the anonymous functions.
 */
class Scope
    extends Call
{
    /**
     * @param array $plugins
     * @param string $name
     */
    function __construct(array $plugins, string $name)
    {
        parent::__construct([$this, 'scope'], [
            new Plugin(App::class, [[SERVICES => $plugins], null, true, true]), new Link, $name]);
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
