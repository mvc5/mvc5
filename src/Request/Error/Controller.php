<?php
/**
 *
 */

namespace Mvc5\Request\Error;

use Mvc5\Arg;
use Mvc5\Http\Error;
use Mvc5\Request\Request;
use Mvc5\View\Model as ViewModel;

class Controller
{
    /**
     *
     */
    use ViewModel;

    /**
     * @param ErrorModel $model
     */
    function __construct(ErrorModel $model)
    {
        $this->model = $model;
    }

    /**
     * @param Request $request
     * @param Error $error
     * @return mixed
     */
    function __invoke(Request $request, Error $error = null)
    {
        return $this->model([Arg::ERROR => $error ?: $request->error()]);
    }
}
