<?php
/**
 *
 */

namespace Mvc5\Log;

use Mvc5\Exception;

class ThrowException
{
    /**
     * @param \Throwable|mixed $exception
     * @param \Throwable|mixed $message
     * @param bool $throw_exception
     * @return \Throwable|mixed
     * @throws \Throwable
     */
    function __invoke($exception = null, $message = null, bool $throw_exception = false)
    {
        $throw_exception && $message instanceof \Throwable
            && Exception::raise($message);

        $throw_exception && $exception instanceof \Throwable
            && Exception::raise($exception);

        return $exception ?: $message;
    }
}
