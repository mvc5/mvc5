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
    protected function param(string $name)
    {
        return $this->service->param($name);
    }

    /**
     * @param $name
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     */
    protected function plugin($name, array $args = [], callable $callback = null)
    {
        return $this->service->plugin($name, $args, $callback);
    }

    /**
     * @param string $name
     * @param $config
     * @return mixed
     */
    protected function shared(string $name, $config = null)
    {
        return $this->service->shared($name, $config);
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
