<?php
/**
 *
 */

namespace Mvc5\Plugin;

use const Mvc5\SESSION;

class Session
    extends Register
{
    /**
     * @param string $name
     * @param mixed $plugin
     */
    function __construct(string $name, $plugin = null)
    {
        parent::__construct($name, SESSION, $plugin);
    }
}
