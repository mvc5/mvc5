<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;

class Service
    extends Plugin
{
    /**
     * @param string $name
     * @param array $args
     * @param array $calls
     */
    function __construct($name, array $args = [], array $calls = [])
    {
        parent::__construct($name, $args, $calls + [Arg::SERVICE => new Link]);
    }
}
