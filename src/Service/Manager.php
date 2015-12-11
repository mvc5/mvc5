<?php
/**
 *
 */

namespace Mvc5\Service;

interface Manager
    extends Container, Service
{
    /**
     * @param array|\ArrayAccess|null $config
     * @return array|\ArrayAccess
     */
    function aliases($config = null);

    /**
     * @param array|\ArrayAccess|null $config
     * @return array|\ArrayAccess|null
     */
    function config($config = null);

    /**
     * @param string $name
     * @param mixed $config
     * @return void
     */
    function configure($name, $config);

    /**
     * @param string $name
     * @return array|callable|null|object|string
     */
    function configured($name);

    /**
     * @param array|\ArrayAccess|null $config
     * @return array|\ArrayAccess|null
     */
    function container($config = null);

    /**
     * @param array|\ArrayAccess|null|\Traversable $config
     * @return array|\ArrayAccess|null|\Traversable
     */
    function events($config = null);

    /**
     * @param array|\ArrayAccess|null $config
     * @return array|\ArrayAccess|null
     */
    function services($config = null);

    /**
     * @param string $name
     * @param callable $callback
     * @param array $args
     * @return array|callable|null|object|string
     */
    function __invoke($name, array $args = [], callable $callback = null);
}
