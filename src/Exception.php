<?php
/**
 *
 */

namespace Mvc5;

class Exception
    extends \Exception
    implements Exception\Throwable
{
    /**
     *
     */
    protected static $invalidArgument = Exception\InvalidArgument::class;

    /**
     *
     */
    protected static $runtime = Exception\Runtime::class;

    /**
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @param array $backtrace
     */
    function __construct($message = '', $code = 0, \Throwable $previous = null, array $backtrace = [])
    {
        parent::__construct($message, $code, $previous);

        $backtrace && isset($backtrace[Arg::FILE])
            && ($this->file = $backtrace[Arg::FILE]) && ($this->line = $backtrace[Arg::LINE]);
    }

    /**
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @param array $backtrace
     * @return mixed
     * @throws \InvalidArgumentException
     */
    final static function exception($message = '', $code = 0, \Throwable $previous = null, array $backtrace = [])
    {
        return static::raise(new static($message, $code, $previous, $backtrace ?: debug_backtrace(0, 1)[0]));
    }

    /**
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @param array $backtrace
     * @return mixed
     * @throws \InvalidArgumentException
     */
    final static function invalidArgument($message = '', $code = 0, \Throwable $previous = null, array $backtrace = [])
    {
        return static::raise(new static::$invalidArgument($message, $code, $previous, $backtrace ?: debug_backtrace(0, 1)[0]));
    }

    /**
     * @param \Exception $exception
     * @return mixed
     * @throws \Exception
     */
    static function raise(\Exception $exception)
    {
        throw $exception;
    }

    /**
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @param array $backtrace
     * @return mixed
     * @throws \RuntimeException
     */
    final static function runtime($message = '', $code = 0, \Throwable $previous = null, array $backtrace = [])
    {
        return static::raise(new static::$runtime($message, $code, $previous, $backtrace ?: debug_backtrace(0, 1)[0]));
    }

    /**
     * @deprecated
     * @return mixed
     * @throws Exception
     */
    function __invoke()
    {
        return static::raise($this);
    }
}
