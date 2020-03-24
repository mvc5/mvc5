<?php
/**
 *
 */

namespace Mvc5\Plugin;

use const Mvc5\SERVICE;

class Service
    extends Plugin
{
    /**
     * @param string $name
     * @param array $args
     * @param array $calls
     */
    function __construct(string $name, array $args = [], array $calls = [])
    {
        parent::__construct($name, $args, $calls + [SERVICE => new Link]);
    }
}
