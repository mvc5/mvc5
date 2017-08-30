<?php
/**
 *
 */

namespace Mvc5\Service;

interface Service
{
    /**
     * @param array|callable|object|string $config
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     */
    function call($config, array $args = [], callable $callback = null);

    /**
     * @param string $name
     * @return mixed
     */
    function param(string $name);

    /**
     * @param $name
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     */
    function plugin($name, array $args = [], callable $callback = null);

    /**
     * @param string $name
     * @param mixed $config
     * @return mixed
     */
    function shared(string $name, $config = null);

    /**
     * @param array|object|string|\Traversable $event
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     */
    function trigger($event, array $args = [], callable $callback = null);
}
