<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;

trait Session
{
    /**
     * @param array|string|null $name
     * @return \Mvc5\Session\Session|mixed
     */
    protected function session($name = null)
    {
        /** @var \Mvc5\Session\Session $session */
        return !($session = $this->plugin(Arg::SESSION)) || null === $name ? $session : $session->get($name);
    }
}
