<?php
/**
 *
 */

namespace Mvc5;

use Psr\Container\ContainerInterface as PSRContainer;

class App
    implements Config\Scope, PSRContainer, \Serializable, Service\Manager
{
    /**
     *
     */
    use Resolver\Resolver;
}
