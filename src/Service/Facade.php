<?php
/**
 *
 */

namespace Mvc5\Service;

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
    protected static function param(string $name)
    {
        return static::service()->param($name);
    }

    /**
     * @param $name
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
     * @param $config
     * @return callable|mixed|null|object
     */
    protected static function shared(string $name, $config = null)
    {
        return static::service()->shared($name, $config);
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
