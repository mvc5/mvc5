<?php
/**
 *
 */

namespace Mvc5\Plugins;

use const Mvc5\SESSION;

trait Session
{
    /**
     * @param array|string|null $name
     * @return \Mvc5\Session\Session|mixed
     */
    protected function session($name = null)
    {
        /** @var \Mvc5\Session\Session $session */
        return !($session = $this->plugin(SESSION)) || null === $name ? $session : $session->get($name);
    }
}
