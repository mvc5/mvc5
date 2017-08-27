<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;

class Session
    extends Register
{
    /**
     * @param string $name
     * @param $plugin
     */
    function __construct(string $name, $plugin = null)
    {
        parent::__construct($name, Arg::SESSION, $plugin);
    }
}
