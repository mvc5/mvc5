<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Mvc5\Exception\RuntimeException;

use function gettype;
use function is_object;
use function is_string;

final class Unresolvable
    extends RuntimeException
{
    /**
     * @param object|string|mixed $message
     * @return string
     */
    protected static function formatMessage($message)  : string
    {
        return !$message ? '' : (
            'Unresolvable plugin: ' . (is_object($message) ? get_class($message) : (is_string($message) ? $message : gettype($message)))
        );
    }

    /**
     * @param $plugin
     * @return mixed
     * @throws \Throwable
     */
    static function plugin($plugin)
    {
        return static::raise(static::create(static::class, [static::formatMessage($plugin)]));
    }

    /**
     * @param object|string|mixed $plugin
     * @throws self
     */
    function __invoke($plugin)
    {
        $this->message = static::formatMessage($plugin);
        throw $this;
    }
}
