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
        $offset && ($origin = $exception->getTrace()[$offset]) && isset($origin[Arg::FILE])
            && ($exception->file = $origin[Arg::FILE]) && ($exception->line = $origin[Arg::LINE]);

        return static::offset($exception, $offset);
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
     * @return \Throwable
     */
    protected static function offset($exception, $offset = 1)
    {
        $offset && $exception->offset = $offset;

        return $exception;
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
