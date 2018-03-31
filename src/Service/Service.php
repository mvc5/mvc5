<?php
/**
 *
 */

namespace Mvc5\Service;

interface Service
{
    /**
     * @param callable|mixed $plugin
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     */
    function call($plugin, array $args = [], callable $callback = null);

    /**
     * @param array|string $name
     * @return mixed
     */
    function param($name);

    /**
     * @param string|mixed $plugin
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     */
    function plugin($plugin, array $args = [], callable $callback = null);

    /**
     * @param string $name
     * @param mixed $config
     * @return mixed
     */
    function shared(string $name, $config = null);

    /**
     * @param array|\Iterator|\Mvc5\Event\Event|object|string $event
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     */
    function trigger($event, array $args = [], callable $callback = null);
}
