<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;

trait User
{
    /**
     * @param string $name
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     */
    protected abstract function plugin($name, array $args = [], callable $callback = null);

    /**
     * @return mixed
     */
    protected function user()
    {
        return $this->plugin(Arg::USER);
    }
}
