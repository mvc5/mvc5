<?php
/**
 *
 */

namespace Mvc5\Controller\Manager;

use Throwable;

interface ControllerManager
{
    /**
     * @param callable $controller
     * @param array $args
     * @return mixed
     */
    function action(callable $controller, array $args = []);

    /**
     * @param array|callable|object|string $config
     * @return callable
     */
    function controller($config);

    /**
     * @param callable $controller
     * @param array $args
     * @return mixed
     */
    function dispatch(callable $controller, array $args = []);

    /**
     * @param Throwable $exception
     * @param array $args
     * @return mixed
     */
    function exception(Throwable $exception, array $args = []);
}
