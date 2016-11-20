<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Mvc5\Exception\Runtime;

class Unresolvable
    extends Runtime
{
    /**
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @param array $backtrace
     */
    function __construct($message = '', $code = 0, \Throwable $previous = null, array $backtrace = [])
    {
        parent::__construct(static::formatMessage($message), $code, $previous, $backtrace);
    }

    /**
     * @param $message
     * @return string
     */
    protected static function formatMessage($message)
    {
        return !$message ? '' : (
            'Unresolvable plugin: ' . (is_object($message) ? get_class($message) : (is_string($message) ? $message : ''))
        );
    }

    /**
     * @param $plugin
     */
    final static function plugin($plugin)
    {
        throw new static($plugin, 0, null, debug_backtrace(0, 1)[0]);
    }

    /**
     * @param $plugin
     */
    function __invoke($plugin)
    {
        $this->message = $this->formatMessage($plugin);
        throw $this;
    }
}
