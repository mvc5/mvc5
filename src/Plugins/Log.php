<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;

trait Log
{
    /**
     * @param array|callable|object|string $name
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     */
    protected abstract function call($name, array $args = [], callable $callback = null);

    /**
     * @param $message
     * @param array $context
     * @param $level
     * @return mixed
     */
    protected function log($message, array $context = [], $level = Arg::SEVERITY_CRITICAL)
    {
        return $this->call(Arg::LOG, [Arg::LEVEL => $level, Arg::MESSAGE => $message, Arg::CONTEXT => $context]);
    }
}
