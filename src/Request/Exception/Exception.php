<?php
/**
 *
 */

namespace Mvc5\Request\Exception;

use Mvc5\Http\Error;
use Mvc5\Http\Error\ServerError;
use Mvc5\Http\Request;

use const Mvc5\{ CONTROLLER, EXCEPTION, NAME, ERROR };

trait Exception
{
    /**
     * @var callable|mixed
     */
    protected $controller;

    /**
     * @var Error
     */
    protected Error $error;

    /**
     * @var string
     */
    protected string $name;

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
            CONTROLLER => $this->controller,
            EXCEPTION => $exception,
            NAME => $this->name,
            ERROR => $this->error
        ]);
    }
}
