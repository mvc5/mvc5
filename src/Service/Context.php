<?php
/**
 *
 */

namespace Mvc5\Service;

use Mvc5\Exception;

final class Context
{
    /**
     * @var Service
     */
    protected static $service;

    /**
     * @param Service|null $service
     */
    function __construct(Service $service = null)
    {
        $service && $this->bind($service);
    }

    /**
     * @param Service $service
     * @return callable|Manager|Service
     */
    static function bind(Service $service)
    {
        isset(static::$service) &&
            Exception::runtime('Service already exists');

        return static::$service = $service;
    }

    /**
     * @param array|callable|object|string $name
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     */
    static function call($name, array $args = [], callable $callback = null)
    {
        return static::service()->call($name, $args, $callback);
    }

    /**
     * @param string $name
     * @return mixed
     */
    static function param(string $name)
    {
        return static::service()->param($name);
    }

    /**
     * @param $name
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     */
    static function plugin($name, array $args = [], callable $callback = null)
    {
        return static::service()->plugin($name, $args, $callback);
    }

    /**
     * @return callable|Manager|Service
     */
    static function service()
    {
        return static::$service ?: Exception::runtime('Service does not exist');
    }

    /**
     * @param $name
     * @param array $args
     * @return mixed
     */
    static function __callStatic(string $name, array $args)
    {
        return static::call($name, $args);
    }

    /**
     * @param Service $service
     */
    function __invoke(Service $service)
    {
        $this->bind($service);
    }
}
