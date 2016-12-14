<?php
/**
 *
 */

namespace Mvc5;

class App
    implements Config\Scope, \Serializable, Service\Manager
{
    /**
     *
     */
    use Resolver\Resolver;
}
