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
    use Exception\Exception;

    /**
     * @var string
     */
    const DOMAIN = Exception\Domain::class;

    /**
     * @var string
     */
    const ERROR_EXCEPTION = Exception\ErrorException::class;

    /**
     * @var string
     */
    const EXCEPTION = self::class;

    /**
     * @var string
     */
    const INVALID_ARGUMENT = Exception\InvalidArgument::class;

    /**
     * @var string
     */
    const RUNTIME = Exception\Runtime::class;
}
