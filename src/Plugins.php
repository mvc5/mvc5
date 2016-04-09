<?php
/**
 *
 */

namespace Mvc5;

class Plugins
    implements Service\Manager, Service\Scope
{
    /**
     *
     */
    use Resolver\Resolver {
        scope as public;
    }
}
