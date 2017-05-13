<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;

trait Session
{
    /**
     * @param $name
     * @return \Mvc5\Session\Session|mixed
     */
    protected function session($name = null)
    {
        return !($session = $this->plugin(Arg::SESSION)) || null === $name ? $session : ($session[$name] ?? null);
    }
}
