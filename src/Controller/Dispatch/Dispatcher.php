<?php
/**
 *
 */

namespace Mvc5\Controller\Dispatch;

use Mvc5\Controller\Manager\ManageController;

class Dispatcher
    implements Action
{
    /**
     *
     */
    use ManageController;

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
