<?php
/**
 *
 */

namespace Mvc5\Mvc\Controller;

use Mvc5\Controller\Manager\ManageController;
use Throwable;

class Dispatcher
    implements Dispatch
{
    /**
     *
     */
    use ManageController;

    /**
     * @param array|callable|object|string $controller
     * @param array $args
     * @return mixed
     */
    public function __invoke($controller, array $args = [])
    {
        try {

            return $this->dispatch($this->controller($controller), $args);

        } catch (Throwable $exception) {

            return $this->exception($exception, $args);

        }
    }
}
