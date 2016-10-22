<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;
use Mvc5\Resolvable;

class Session
    extends Register
{
    /**
     * @param string $name
     * @param mixed|null|Resolvable $plugin
     */
    function __construct($name, $plugin = null)
    {
        parent::__construct($name, Arg::SESSION, $plugin);
    }
}
