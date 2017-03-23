<?php
/**
 *
 */

namespace Mvc5\Request\Exception;

use Mvc5\Arg;
use Mvc5\Http\Error\ServerError;
use Mvc5\Http\Request;
use Throwable;

trait Exception
{
    /**
     * @var
     */
    protected $controller;

    /**
     * @var
     */
    protected $name;

    /**
     * @param $name
     * @param $controller
     */
    function __construct($name, $controller)
    {
        $this->controller = $controller;
        $this->name       = $name;
    }

    /**
     * @param Request $request
     * @param Throwable $exception
     * @return Request
     */
    function __invoke(Request $request, Throwable $exception)
    {
        return $request->with([
            Arg::CONTROLLER => $this->controller,
            Arg::EXCEPTION => $exception,
            Arg::NAME => $this->name,
            Arg::ERROR => new ServerError
        ]);
    }
}
