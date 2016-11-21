<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Mvc5\Exception\Base;
use Mvc5\Exception\Throwable;

class Unresolvable
    extends \RuntimeException
    implements Throwable
{
    /**
     *
     */
    use Base;

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
     * @throws self
     */
    final static function plugin($plugin)
    {
        static::raise(static::create(static::class, static::formatMessage($plugin)));
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
