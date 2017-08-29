<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;

trait Log
{
    /**
     * @param mixed $message
     * @param array $context
     * @param int $level
     * @return mixed
     */
    protected function log($message, array $context = [], int $level = Arg::SEVERITY_CRITICAL)
    {
        return $this->call(Arg::LOG, [Arg::LEVEL => $level, Arg::MESSAGE => $message, Arg::CONTEXT => $context]);
    }
}
