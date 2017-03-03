<?php
/**
 *
 */

namespace Mvc5\Route\Dispatch;

use Mvc5\Arg;
use Mvc5\Http\Request;

class Collection
{
    /**
     *
     */
    use Router;

    /**
     * @param $name
     * @param $parent
     * @return string
     */
    protected function name($name, $parent)
    {
        return !$parent ? $name : $parent . Arg::SEPARATOR . $name;
    }

    /**
     * @param Request $request
     * @return Request
     */
    function __invoke(Request $request)
    {
        return $this->result($request, $this->traverse($request, $this->route));
    }
}
