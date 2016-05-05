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
     * @return array|\ArrayAccess|null
     */
    function config($config = null);

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    function configure($name, $value);

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
}
