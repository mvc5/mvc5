<?php
/**
 *
 */

namespace Mvc5\Service;

trait Plugin
{
    /**
     * @var Service
     */
    protected $service;

    /**
     * @param array|callable|object|string $name
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     */
    protected function call($name, array $args = [], callable $callback = null)
    {
        return $this->service->call($name, $args, $callback);
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function param($name)
    {
        return $this->service->param($name);
    }

    /**
     * @param string $name
     * @param array $args
     * @param callable $callback
     * @return callable|null|object
     */
    protected function plugin($name, array $args = [], callable $callback = null)
    {
        return $this->service->plugin($name, $args, $callback);
    }

    /**
     * @param array|object|string|\Traversable $event
     * @param array $args
     * @param callable $callback
     * @return mixed|null
     */
    protected function trigger($event, array $args = [], callable $callback = null)
    {
        return $this->service->trigger($event, $args, $callback);
    }
}
