<?php
/**
 *
 */

namespace Mvc5;

use Psr\Container\ContainerInterface;

class App
    extends Config
    implements Config\Scope, ContainerInterface, \Serializable, Service\Manager
{
    /**
     *
     */
    use Resolver\Resolver;
}
