<?php
/**
 *
 */

namespace Mvc5;

use Psr\Container\ContainerInterface;

class App
    implements Config\Scope, ContainerInterface, \Serializable, Service\Manager
{
    /**
     *
     */
    use Resolver\Resolver;
}
