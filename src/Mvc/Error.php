<?php
/**
 *
 */

namespace Mvc5\Mvc;

use Mvc5\Plugin;
use Mvc5\Response\Error as ResponseError;
use Mvc5\Controller\Action;

class Error
{
    /**
     *
     */
    use Action;
    use Plugin;

    /**
     * @param $response
     * @param $model
     * @return mixed
     */
    function __invoke($response, $model = null)
    {
        return $model instanceof ResponseError ? $this->error($model, $response) : $model;
    }
}
