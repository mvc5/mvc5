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
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @param array $backtrace
     */
    function __construct($message = '', $code = 0, \Throwable $previous = null, array $backtrace = [])
    {
        $this->code     = $code;
        $this->message  = $message;
        $this->previous = $previous;

        $backtrace && isset($backtrace[Arg::FILE])
            && ($this->file = $backtrace[Arg::FILE]) && ($this->line = $backtrace[Arg::LINE]);
    }

    /**
     * @param $exception
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @param int $offset
     * @return mixed|_Exception|InvalidArgument|Runtime
     */
    protected static function create($exception, $message = '', $code = 0, \Throwable $previous = null, $offset = 2)
    {
        return new $exception($message, $code, $previous, debug_backtrace(0, $offset)[$offset - 1]);
    }

    /**
     * @param $exception
     * @return mixed
     * @throws _Exception|InvalidArgument|Runtime|\Throwable
     */
    static function raise($exception)
    {
        throw $exception;
    }
}
