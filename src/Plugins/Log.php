<?php
/**
 *
 */

namespace Mvc5\Plugins;

use const Mvc5\{ CONTEXT, LEVEL, LOG, MESSAGE, SEVERITY_CRITICAL };

trait Log
{
    /**
     * @param mixed $message
     * @param array $context
     * @param int $level
     * @return mixed
     */
    protected function log($message, array $context = [], int $level = SEVERITY_CRITICAL)
    {
        return $this->call(LOG, [LEVEL => $level, MESSAGE => $message, CONTEXT => $context]);
    }
}
