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
     * @return mixed
     */
    public function __invoke(Response $response, $model)
    {
        $response->setContent($model);

        return $response;
    }
}
