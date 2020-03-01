<?php
/**
 *
 */

namespace Mvc5\Exception;

trait Generator
{
    /**
     *
     */
    use Exception;

    /**
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @param int $offset
     * @return mixed
     * @throws \DomainException|\Throwable
     */
    static function domain(string $message = '', int $code = 0, \Throwable $previous = null, int $offset = 2)
    {
        return static::raise(static::create(static::DOMAIN, [$message, $code, $previous], $offset));
    }

    /**
     * @param string $message
     * @param int $code
     * @param int $severity
     * @param string $file
     * @param int $line
     * @param \Throwable|null $previous
     * @param int $offset
     * @return mixed
     * @throws \ErrorException|\Throwable
     */
    static function errorException(
        string $message = '', int $code = 0, int $severity = E_ERROR,
        string $file = __FILE__, int $line = __LINE__, \Throwable $previous = null, int $offset = 2
    ) {
        return static::raise(static::origin(
            static::instance(static::ERROR_EXCEPTION, [$message, $code, $severity, $file, $line, $previous]), $offset
        ));
    }

    /**
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @param int $offset
     * @return mixed
     * @throws \Exception|\Throwable
     */
    static function exception(string $message = '', int $code = 0, \Throwable $previous = null, int $offset = 2)
    {
        return static::raise(static::create(static::EXCEPTION, [$message, $code, $previous], $offset));
    }

    /**
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @param int $offset
     * @return mixed
     * @throws \InvalidArgumentException|\Throwable
     */
    static function invalidArgument(string $message = '', int $code = 0, \Throwable $previous = null, int $offset = 2)
    {
        return static::raise(static::create(static::INVALID_ARGUMENT, [$message, $code, $previous], $offset));
    }

    /**
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @param int $offset
     * @return mixed
     * @throws \RuntimeException|\Throwable
     */
    static function runtime(string $message = '', int $code = 0, \Throwable $previous = null, int $offset = 2)
    {
        return static::raise(static::create(static::RUNTIME, [$message, $code, $previous], $offset));
    }

    /**
     * @param string $name
     * @param array $args
     * @return mixed
     * @throws \Throwable
     */
    static function __callStatic(string $name, array $args)
    {
        return static::raise(static::create($name, $args));
    }
}
