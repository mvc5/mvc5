<?php
/**
 *
 */

namespace Mvc5\Response;

use Throwable;

use const Mvc5\{ CODE, FILE, HTTP_SERVER_ERROR, LINE, MESSAGE, TRACE };

class JsonExceptionResponse
    extends JsonResponse
{
    /**
     * @param Throwable $exception
     * @param bool|false $trace
     * @throws Throwable
     */
    function __construct(Throwable $exception, bool $trace = false)
    {
        parent::__construct(
            $trace ? [
                CODE => $exception->getCode(),
                MESSAGE => $exception->getMessage(),
                LINE => $exception->getLine(),
                FILE => $exception->getFile(),
                TRACE => $exception->getTrace()
            ] : [MESSAGE => ''],
            HTTP_SERVER_ERROR
        );
    }
}
