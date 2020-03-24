<?php
/**
 *
 */

namespace Mvc5\Request\Exception;

use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Plugins\Service;
use Mvc5\View\ViewLayout;
use Throwable;

use const Mvc5\{ ACCEPTS_JSON, EXCEPTION, EXCEPTION_LAYOUT, RESPONSE_JSON_EXCEPTION };

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
        return $this->plugin(RESPONSE_JSON_EXCEPTION, [EXCEPTION => $exception]);
    }

    /**
     * @param Throwable $exception
     * @return ViewLayout
     */
    protected function layout(Throwable $exception) : ViewLayout
    {
        return $this->plugin(EXCEPTION_LAYOUT, [EXCEPTION => $exception]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    function __invoke(Request $request)
    {
        return $request[ACCEPTS_JSON] ? $this->json($request[EXCEPTION]) : $this->layout($request[EXCEPTION]);
    }
}
