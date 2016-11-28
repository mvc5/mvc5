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
     * @return Service
     */
    static function bind(Service $service)
    {
        isset(static::$service) &&
            Exception::runtime('Service already exists');

        return static::$service = $service;
    }

    /**
     * @return Container|Service
     */
    static function service()
    {
        return static::$service ?: Exception::runtime('Service does not exist');
    }

    /**
     * @param Service $service
     */
    function __invoke(Service $service)
    {
        $this->bind($service);
    }
}
