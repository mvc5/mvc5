<?php
/**
 *
 */

namespace Mvc5\Log;

class Exception
{
    /**
     * @param \Throwable|mixed|null $exception
     * @param \Throwable|mixed|null $message
     * @param bool $throw_exception
     * @return \Throwable|mixed|null
     * @throws \Throwable
     */
    function __invoke($exception = null, $message = null, $throw_exception = false)
    {
        if ($throw_exception && $message instanceof \Throwable) {
            throw $message;
        }

        if ($throw_exception && $exception instanceof \Throwable) {
            throw $exception;
        }

        return $exception ?: $message;
    }
}
