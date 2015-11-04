<?php
/**
 *
 */

namespace Mvc5\View\Exception;

use Mvc5\View\Layout\LayoutModel;
use Throwable;

interface ExceptionModel
    extends LayoutModel
{
    /**
     *
     */
    const EXCEPTION = 'exception';

    /**
     * @param Throwable $exception
     * @return mixed
     */
    function exception(Throwable $exception);
}
