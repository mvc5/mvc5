<?php
/**
 *
 */

namespace Mvc5\Mvc;

use Mvc5\Controller\Dispatch;
use Mvc5\Plugin;
use Throwable;

class Controller
{
    /**
     *
     */
    use Dispatch;
    use Plugin;

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

            return $this->exception($exception, $controller);

        }
    }
}
