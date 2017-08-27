<?php
/**
 *
 */

namespace Mvc5\Request\Exception;

use Mvc5\Arg;
use Mvc5\Http\Error;
use Mvc5\Http\Error\ServerError;
use Mvc5\Http\Request;

trait Exception
{
    /**
     * @var mixed|callable
     */
    protected $controller;

    /**
     * @var mixed|Error
     */
    protected $error;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
     * @param mixed|callable $controller
     * @param Error $error
     */
    function __construct(string $name, $controller, Error $error = null)
    {
        $this->controller = $controller;
        $this->error = $error ?: new ServerError;
        $this->name = $name;
    }

    /**
     * @param Request $request
     * @param \Throwable $exception
     * @return Request
     */
    function __invoke(Request $request, \Throwable $exception)
    {
        return $request->with([
            Arg::CONTROLLER => $this->controller,
            Arg::EXCEPTION => $exception,
            Arg::NAME => $this->name,
            Arg::ERROR => $this->error
        ]);
    }
}
