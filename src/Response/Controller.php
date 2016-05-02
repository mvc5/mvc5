<?php
/**
 *
 */

namespace Mvc5\Response;

class Controller
{
    /**
     * @param Response $response
     * @param $model
     * @return Response
     */
    function __invoke(Response $response, $model)
    {
        return $response->setContent($model);
    }
}
