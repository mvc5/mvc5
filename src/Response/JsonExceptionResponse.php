<?php
/**
 *
 */

namespace Mvc5\Response;

use Mvc5\Arg;
use Throwable;

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
                Arg::CODE => $exception->getCode(),
                Arg::MESSAGE => $exception->getMessage(),
                Arg::LINE => $exception->getLine(),
                Arg::FILE => $exception->getFile(),
                Arg::TRACE => $exception->getTrace()
            ] : [Arg::MESSAGE => ''],
            Arg::HTTP_SERVER_ERROR
        );
    }
}
