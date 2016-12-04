<?php
/**
 *
 */

namespace Mvc5\Exception;

trait Exception
{
    /**
     *
     */
    use Base;

    /**
     * @param string $message
     * @param int $code
     * @param int $severity
     * @param string $file
     * @param int $line
     * @param \Throwable|null $previous
     * @param int $offset
     * @return mixed
     * @throws \ErrorException
     */
    static function errorException(
        $message = '', $code = 0, $severity = E_ERROR, $file = __FILE__, $line = __LINE__, \Throwable $previous = null, $offset = 2
    ) {
        return static::raise(static::offset(
            static::instance(static::ERROR_EXCEPTION, [$message, $code, $severity, $file, $line, $previous]), $offset
        ));
    }

    /**
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @param int $offset
     * @return mixed
     * @throws \Exception
     */
    static function exception($message = '', $code = 0, \Throwable $previous = null, $offset = 2)
    {
        return static::raise(static::create(static::class, [$message, $code, $previous], $offset));
    }

    /**
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @param int $offset
     * @return mixed
     * @throws \InvalidArgumentException
     */
    static function invalidArgument($message = '', $code = 0, \Throwable $previous = null, $offset = 2)
    {
        return static::raise(static::create(static::INVALID_ARGUMENT, [$message, $code, $previous], $offset));
    }

    /**
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @param int $offset
     * @return mixed
     * @throws \RuntimeException
     */
    static function runtime($message = '', $code = 0, \Throwable $previous = null, $offset = 2)
    {
        return static::raise(static::create(static::RUNTIME, [$message, $code, $previous], $offset));
    }
}
