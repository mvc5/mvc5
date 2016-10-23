<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;

trait Flash
{
    /**
     * @param string $message
     * @param string $type
     * @param string $name
     */
    protected function flash($message, $type = Arg::INFO, $name = '')
    {
        $this->plugin(Arg::FLASH_MESSAGES)->flash($message, $type, $name);
    }

    /**
     * @param string $name
     * @param array $args
     * @param callable $callback
     * @return callable|null|object
     */
    protected abstract function plugin($name, array $args = [], callable $callback = null);
}
