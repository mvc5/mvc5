<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;

trait Config
{
    /**
     * @return mixed
     */
    protected function config()
    {
        return $this->plugin(Arg::CONFIG);
    }

    /**
     * @param string $name
     * @param array $args
     * @param callable $callback
     * @return callable|null|object
     */
    protected abstract function plugin($name, array $args = [], callable $callback = null);
}
