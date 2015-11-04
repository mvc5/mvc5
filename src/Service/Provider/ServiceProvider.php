<?php
/**
 *
 */

namespace Mvc5\Service\Provider;

use Mvc5\Config\Configuration;
use Mvc5\Event\Event;
use Mvc5\Service\Config\Configuration as Config;

interface ServiceProvider
{
    /**
     * @param array|callable|object|string $config
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     * @throws \RuntimeException
     */
    function call($config, array $args = [], callable $callback = null);

    /**
     * @return Configuration
     */
    function config();

    /**
     * @param string $name
     * @return array|callable|Config|null|object|string
     */
    function configured($name);

    /**
     * @param array|callable|Configuration|null|object|string $config
     * @param array $args
     * @param callable $callback
     * @return callable|null|object
     */
    function create($config, array $args = [], callable $callback = null);

    /**
     * @param string $name
     * @return null|object|callable
     */
    function get($name);
    
    /**
     * @param string $name
     * @return mixed
     */
    function param($name);

    /**
     * @param string $name
     * @param callable $callback
     * @param array $args
     * @return callable|null|object
     */
    function plugin($name, array $args = [], callable $callback = null);

    /**
     * @param array|Event|string $event
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    function trigger($event, array $args = [], callable $callback = null);
}
