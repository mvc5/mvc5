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
     * @var callable|mixed
     */
    protected $controller;

    /**
     * @var Error|mixed
     */
    protected $error;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
     * @param callable|mixed $controller
     * @param Error|null $error
     */
    function __construct(string $name, $controller, Error $error = null)
    {
        $this->controller = $controller;
        $this->error = $error ?? new ServerError;
        $this->name = $name;
    }

    /**
     * @param Request $request
     * @param \Throwable $exception
     * @return Request
     */
    function __invoke(Request $request, \Throwable $exception) : Request
    {
        return $request->with([
            Arg::CONTROLLER => $this->controller,
            Arg::EXCEPTION => $exception,
            Arg::NAME => $this->name,
            Arg::ERROR => $this->error
        ]);
    }
}
