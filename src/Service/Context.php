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
     * @throws \Throwable
     */
    function __construct(Service $service = null)
    {
        $service && $this->bind($service);
    }

    /**
     * @param Service $service
     * @return callable|Manager|Service
     * @throws \RuntimeException
     */
    static function bind(Service $service)
    {
        isset(static::$service) &&
            Exception::runtime('Service already exists');

        return static::$service = $service;
    }

    /**
     * @param callable|mixed $plugin
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     * @throws \Throwable
     */
    static function call($plugin, array $args = [], callable $callback = null)
    {
        return static::service()->call($plugin, $args, $callback);
    }

    /**
     * @param array|string $name
     * @return mixed
     * @throws \Throwable
     */
    static function param($name)
    {
        return static::service()->param($name);
    }

    /**
     * @param string|mixed $plugin
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     * @throws \Throwable
     */
    static function plugin($plugin, array $args = [], callable $callback = null)
    {
        return static::service()->plugin($plugin, $args, $callback);
    }

    /**
     * @return callable|Manager|Service
     * @throws \RuntimeException
     */
    static function service()
    {
        return static::$service ?? Exception::runtime('Service does not exist');
    }

    /**
     * @param string $name
     * @param array $args
     * @return mixed
     * @throws \Throwable
     */
    static function __callStatic(string $name, array $args)
    {
        return static::call($name, $args);
    }

    /**
     * @param Service $service
     * @throws \Throwable
     */
    function __invoke(Service $service)
    {
        $this->bind($service);
    }
}
