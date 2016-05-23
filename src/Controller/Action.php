<?php
/**
 *
 */

namespace Mvc5\Controller;

use Mvc5\Plugin;

class Action
{
    /**
     *
     */
    use Plugin;

    /**
     * @param $controller
     * @param array $args
     * @return mixed
     */
    function __invoke($controller, array $args = [])
    {
        return $this->call($controller, $args);
    }
}
