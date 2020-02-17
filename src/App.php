<?php
/**
 *
 */

namespace Mvc5;

use Psr\Container\ContainerInterface;

class App
    extends Config
    implements Config\Scope, ContainerInterface, Service\Manager
{
    /**
     *
     */
    use Resolver\Resolver;
}
