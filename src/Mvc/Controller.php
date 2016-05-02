<?php
/**
 *
 */

namespace Mvc5\Mvc;

use Mvc5\Controller\Action;
use Mvc5\Plugin;
use Throwable;

class Controller
{
    /**
     *
     */
    use Action;
    use Plugin;

    /**
     * @param array|callable|object|string $controller
     * @param array $args
     * @return mixed
     */
    function __invoke($controller, array $args = [])
    {
        try {

            return $this->action($controller, $args);

        } catch (Throwable $exception) {

            return $this->exception($exception, $controller);

        }
    }
}
