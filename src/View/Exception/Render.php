<?php
/**
 *
 */

namespace Mvc5\View\Exception;

use Throwable;

interface Render
{
    /**
     * @param Throwable $exception
     * @param ExceptionModel $model
     * @return mixed
     */
    function __invoke(Throwable $exception, ExceptionModel $model);
}
