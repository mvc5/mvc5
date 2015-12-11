<?php
/**
 *
 */

namespace Mvc5\Controller;

use Mvc5\Arg;
use Throwable;

trait Dispatcher
{
    /**
     * @param callable $controller
     * @param array $args
     * @return mixed
     */
    protected function action(callable $controller, array $args = [])
    {
        return $this->call($controller, $args);
    }

    /**
     * @param array|callable|object|string $config
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     * @throws \RuntimeException
     */
    protected abstract function call($config, array $args = [], callable $callback = null);

    /**
     * @param array|callable|object|string $config
     * @return callable
     */
    protected function controller($config)
    {
        return $this->invokable($config);
    }

    /**
     * @param callable $controller
     * @param array $args
     * @return mixed
     */
    protected function dispatch(callable $controller, array $args = [])
    {
        return $this->call(Arg::CONTROLLER_DISPATCH, [Arg::CONTROLLER => $controller] + $args);
    }

    /**
     * @param Throwable $exception
     * @param $controller
     * @return mixed
     */
    protected function exception(Throwable $exception, $controller)
    {
        return $this->call(Arg::CONTROLLER_EXCEPTION, [Arg::EXCEPTION => $exception, Arg::CONTROLLER => $controller]);
    }

    /**
     * @param array|callable|object|string $config
     * @return callable|null
     */
    protected abstract function invokable($config) : callable;
}
