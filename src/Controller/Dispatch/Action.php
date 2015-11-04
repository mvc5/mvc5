<?php
/**
 *
 */

namespace Mvc5\Controller\Dispatch;

interface Action
{
    /**
     * @param callable $controller
     * @param array $args
     * @return mixed
     */
    function __invoke(callable $controller, array $args = []);
}
