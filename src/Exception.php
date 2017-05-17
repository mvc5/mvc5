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
    use Exception\Generator;

    /**
     * @var string
     */
    const DOMAIN = Exception\DomainException::class;

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
    const INVALID_ARGUMENT = Exception\InvalidArgumentException::class;

    /**
     * @var string
     */
    const RUNTIME = Exception\RuntimeException::class;
}
