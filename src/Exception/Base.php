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
     * @param $exception
     * @param array $backtrace
     * @return \Throwable
     */
    protected static function backtrace($exception, array $backtrace = [])
    {
        $backtrace && isset($backtrace[Arg::FILE])
            && ($exception->file = $backtrace[Arg::FILE]) && ($exception->line = $backtrace[Arg::LINE]);

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
    protected static function create($exception, $message = '', $code = 0, \Throwable $previous = null, $offset = 2)
    {
        return static::backtrace(new $exception($message, $code, $previous), debug_backtrace(0, $offset)[$offset - 1]);
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
