<?php
/**
 *
 */

namespace Mvc5\Service\Manager;

use Mvc5\Service\Config\Configuration;
use Mvc5\Service\Container\ServiceContainer;
use RuntimeException;

interface ServiceManager
    extends ServiceContainer
{
    /**
     * @param array|callable|object|string $config
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     * @throws RuntimeException
     */
    function call($config, array $args = [], callable $callback = null);

    /**
     * @param array|callable|Configuration|null|object|string $config
     * @param array $args
     * @param callable $callback
     * @return callable|null|object
     */
    function create($config, array $args = [], callable $callback = null);

    /**
     * @param string $name
     * @param array $args
     * @param callable $callback
     * @return callable|null|object
     */
    function get($name, array $args = [], callable $callback = null);

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
     * @param string $name
     * @param callable $callback
     * @param array $args
     * @return array|callable|null|object|string
     */
    function __invoke($name, array $args = [], callable $callback = null);
}
