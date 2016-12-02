<?php
/**
 *
 */

namespace Mvc5\Service;

use Mvc5\Arg;

trait Facade
{
    /**
     * @param array|callable|object|string $name
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     */
    protected static function call($name, array $args = [], callable $callback = null)
    {
        return static::service()->call($name, $args, $callback);
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected static function param($name)
    {
        return static::service()->param($name);
    }

    /**
     * @param string $name
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     */
    protected static function plugin($name, array $args = [], callable $callback = null)
    {
        return static::service()->plugin($name, $args, $callback);
    }

    /**
     * @return callable|Manager|Service
     */
    protected static function service()
    {
        return Context::service();
    }

    /**
     * @param string $name
     * @return callable|mixed|null|object
     */
    protected static function shared($name)
    {
        return static::call(Arg::SHARED, [$name]);
    }

    /**
     * @param array|object|string|\Traversable $event
     * @param array $args
     * @param callable $callback
     * @return mixed|null
     */
    protected static function trigger($event, array $args = [], callable $callback = null)
    {
        return static::service()->trigger($event, $args, $callback);
    }
}
