<?php
/**
 *
 */

namespace Mvc5\Controller;

use Mvc5\Plugins\Service;

final class Action
{
    /**
     *
     */
    use Service;

    /**
     * @param mixed $controller
     * @param array $argv
     * @return mixed
     */
    function __invoke($controller = null, array $argv = [])
    {
        return $controller ? $this->call($controller, $argv) : null;
    }
}
