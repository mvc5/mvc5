<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;
use Mvc5\Config\Configuration;

trait Config
{
    /**
     * @return array|Configuration|mixed
     */
    protected function config()
    {
        return $this->plugin(Arg::CONFIG);
    }

    /**
     * @param string $name
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     */
    protected abstract function plugin($name, array $args = [], callable $callback = null);
}
