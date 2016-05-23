<?php
/**
 *
 */

namespace Mvc5\Request\Error;

use Mvc5\Arg;
use Mvc5\View\Model as _ViewModel;
use Mvc5\Response\Error;
use Mvc5\Request\Request;

class Controller
{
    /**
     *
     */
    use _ViewModel;

    /**
     * @param ViewModel $model
     */
    function __construct(ViewModel $model)
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
