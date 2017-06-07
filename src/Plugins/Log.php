<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;

trait Log
{
    /**
     * @param $message
     * @param array $context
     * @param int $level
     * @return mixed
     */
    protected function log($message, array $context = [], $level = Arg::SEVERITY_CRITICAL)
    {
        return $this->call(Arg::LOG, [Arg::LEVEL => $level, Arg::MESSAGE => $message, Arg::CONTEXT => $context]);
    }
}
