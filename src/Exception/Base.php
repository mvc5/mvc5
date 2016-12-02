<?php
/**
 *
 */

namespace Mvc5\Exception;

use Mvc5\Arg;
use Mvc5\Exception as _Exception;

trait Base
{
    /**
     * @param \Exception|mixed $exception
     * @param int $offset
     * @return \Exception
     */
    protected static function offset($exception, $offset = 1)
    {
        ($exception->offset = $offset) && ($trace = $exception->getTrace()[$offset]) && isset($trace[Arg::FILE])
            && ($exception->file = $trace[Arg::FILE]) && ($exception->line = $trace[Arg::LINE]);

        return $exception;
    }

    /**
     * @param $exception
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @param int $offset
     * @return mixed|_Exception|InvalidArgument|Runtime|\Throwable
     */
    protected static function create($exception, $message = '', $code = 0, \Throwable $previous = null, $offset = 1)
    {
        return static::offset(new $exception($message, $code, $previous), $offset);
    }

    /**
     * @param $exception
     * @return mixed
     * @throws mixed|_Exception|InvalidArgument|Runtime|\Throwable
     */
    static function raise($exception)
    {
        throw $exception;
    }
}
