<?php
/**
 *
 */

namespace Mvc5\Request\Exception;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Plugins\Service;
use Mvc5\View\ViewLayout;
use Throwable;

class Controller
{
    /**
     *
     */
    use Service;

    /**
     * @param Throwable $exception
     * @return Response
     */
    protected function json(Throwable $exception) : Response
    {
        return $this->plugin(Arg::RESPONSE_JSON_EXCEPTION, [Arg::EXCEPTION => $exception]);
    }

    /**
     * @param Throwable $exception
     * @return ViewLayout
     */
    protected function layout(Throwable $exception) : ViewLayout
    {
        return $this->plugin(Arg::EXCEPTION_LAYOUT, [Arg::EXCEPTION => $exception]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    function __invoke(Request $request)
    {
        return $request[Arg::ACCEPTS_JSON] ? $this->json($request[Arg::EXCEPTION]) : $this->layout($request[Arg::EXCEPTION]);
    }
}
