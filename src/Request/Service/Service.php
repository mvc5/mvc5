<?php
/**
 *
 */

namespace Mvc5\Request\Service;

use Mvc5\Arg;
use Mvc5\Config\Model;
use Mvc5\Http\Request;

trait Service
{
    /**
     * @var Model
     */
    protected $service;

    /**
     * @param Model $service
     */
    function __construct(Model $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return Request
     */
    protected function share(Request $request)
    {
        return $this->service[Arg::REQUEST] = $request;
    }

    /**
     * @param Request $request
     * @return Request
     */
    function __invoke(Request $request)
    {
        return $this->share($request);
    }
}
