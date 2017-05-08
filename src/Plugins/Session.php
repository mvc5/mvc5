<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;
use Mvc5\Session\Session as _Session;

trait Session
{
    /**
     * @param $name
     * @return mixed|_Session
     */
    protected function session($name = null)
    {
        return !($session = $this->plugin(Arg::SESSION)) || null === $name ? $session : ($session[$name] ?? null);
    }
}
