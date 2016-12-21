<?php
/**
 *
 */

namespace Mvc5\Exception;

use Mvc5\Exception as _Exception;

class ErrorException
    extends \ErrorException
    implements Throwable
{
    /**
     *
     */
    use Base;

    /**
     *
     */
    const EXIT_CODE = 70;

    /**
     * @param $severity
     * @param $message
     * @param $file
     * @param $line
     * @codeCoverageIgnore
     */
    static function handler($severity, $message, $file, $line)
    {
        $exception = new self($message, 0, $severity, $file, $line);
        include __DIR__ . '/../../view/exception.phtml';
        exit(static::EXIT_CODE);
    }
}
