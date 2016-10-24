<?php
/**
 *
 */

namespace Mvc5\Controller;

use Mvc5\Plugin;
use Mvc5\Service;

class Action
{
    /**
     *
     */
    use Plugin;

    /**
     * @param $controller
     * @return mixed
     */
    protected function controller($controller)
    {
        $controller instanceof Service && !$controller->service()
            && $controller->service($this->service());

        return $controller;
    }

    /**
     * @param $controller
     * @return callable|null|object
     */
    protected function resolve($controller)
    {
        return is_string($controller) ? $this->plugin($controller) : $controller;
    }

    /**
     * @param $controller
     * @param array $args
     * @return mixed
     */
    function __invoke($controller = null, array $args = [])
    {
        return $controller ? $this->call($this->controller($this->resolve($controller)), $args) : null;
    }
}
