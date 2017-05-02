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
     * @param string $name
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     */
    protected abstract function plugin($name, array $args = [], callable $callback = null);

    /**
     * @param $name
     * @return mixed|_Session
     */
    protected function session($name = null)
    {
        return !($session = $this->plugin(Arg::SESSION)) || null === $name ? $session : ($session[$name] ?? null);
    }
}
