<?php
/**
 *
 */

namespace Mvc5\Exception;

use Mvc5\Arg;

trait Exception
{
    /**
     * @param mixed|\Throwable $exception
     * @param int $offset
     * @return \Throwable
     */
    protected static function backtrace(\Throwable $exception, $offset = 2)
    {
        return static::origin(
            $exception, $offset, $offset && ($origin = $exception->getTrace()[$offset]) ? $origin : []);
    }

    /**
     * @param string $exception
     * @param array|string $params
     * @param int $offset
     * @return \Throwable
     */
    protected static function create($exception, $params = [], $offset = 2)
    {
        return static::backtrace(static::instance($exception, (array) $params), $offset);
    }

    /**
     * @param string $exception
     * @param array $params
     * @return \Throwable
     */
    protected static function instance($exception, array $params = [])
    {
        return new $exception(...$params);
    }

    /**
     * @param \Throwable $exception
     * @param int $offset
     * @param array $origin
     * @return \Throwable
     */
    protected static function origin($exception, $offset = 1, array $origin = [])
    {
        if (!$exception instanceof \Error) {
            if (!empty($origin[Arg::FILE])) {
                $exception->file = $origin[Arg::FILE];
                $exception->line = $origin[Arg::LINE];
            }
            $offset && $exception->offset = $offset;
            return $exception;
        }

        return (new class extends \Error {
            function __invoke(\Throwable $error, $offset, array $origin) {
                if (!empty($origin[Arg::FILE])) {
                    $error->file = $origin[Arg::FILE];
                    $error->line = $origin[Arg::LINE];
                }
                $offset && $error->offset = $offset;
                return $error;
            }
        })($exception, $offset, $origin);
    }

    /**
     * @param $exception
     * @return mixed
     * @throws \Throwable
     */
    static function raise(\Throwable $exception)
    {
        throw $exception;
    }
}
