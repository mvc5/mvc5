<?php
/**
 *
 */

namespace Mvc5\Controller;

use Mvc5\Plugin;
use Mvc5\Request\Request;

class Action
{
    /**
     *
     */
    use Plugin;

    /**
     * @param Request $request
     * @param array $args
     * @return mixed
     */
    function __invoke(Request $request, array $args = [])
    {
        return $this->call($request->controller(), $args);
    }
}
