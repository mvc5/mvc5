<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Mvc5\Exception\RuntimeException;

class Unresolvable
    extends RuntimeException
{
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
     * @return mixed
     * @throws self
     */
    final static function plugin($plugin)
    {
        return static::raise(static::create(static::class, [static::formatMessage($plugin)]));
    }

    /**
     * @param $plugin
     * @throws self
     */
    function __invoke($plugin)
    {
        $this->message = static::formatMessage($plugin);
        throw $this;
    }
}
