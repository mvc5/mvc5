<?php
/**
 *
 */

namespace Mvc5\Request\Error;

use Mvc5\Http\Request;

use const Mvc5\{ CONTROLLER, ERROR, NAME };

trait Error
{
    /**
     * @var mixed
     */
    protected $controller;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @param string $name
     * @param mixed $controller
     */
    function __construct(string $name, $controller)
    {
        $this->controller = $controller;
        $this->name       = $name;
    }

    /**
     * @param Request $request
     * @return Request
     */
    protected function request(Request $request) : Request
    {
        return !$request[ERROR] ? $request :
            $request->with([CONTROLLER => $this->controller, NAME => $this->name]);
    }

    /**
     * @param Request $request
     * @return Request
     */
    function __invoke(Request $request) : Request
    {
        return $this->request($request);
    }
}
