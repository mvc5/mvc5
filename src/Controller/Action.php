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
    use Dispatcher;
    use Plugin;

    /**
     * @param callable $controller
     * @param array $args
     * @return mixed
     */
    public function __invoke(callable $controller, array $args = [])
    {
        return $this->action($controller, $args);
    }
}
