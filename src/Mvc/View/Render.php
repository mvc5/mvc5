<?php
/**
 *
 */

namespace Mvc5\Mvc\View;

use Mvc5\Response\Response;

interface Render
{
    /**
     * @param Response $response
     * @param $model
     * @return mixed
     */
    function __invoke(Response $response, $model = null);
}
