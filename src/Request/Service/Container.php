<?php
/**
 *
 */

namespace Mvc5\Request\Service;

use Mvc5\Arg;
use Mvc5\Config\Model;
use Mvc5\Http\Request;

trait Container
{
    /**
     * @var Model
     */
    protected Model $container;

    /**
     * @param Model $container
     */
    function __construct(Model $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @return Request
     */
    protected function share(Request $request) : Request
    {
        return $this->container[Arg::REQUEST] = $request;
    }

    /**
     * @param Request $request
     * @return Request
     */
    function __invoke(Request $request) : Request
    {
        return $this->share($request);
    }
}
