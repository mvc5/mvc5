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
        $success = true;
        while(ob_get_level() && $success) {
            $success = ob_end_clean();
        }

        $exception = new self($message, 0, $severity, $file, $line);

        http_response_code(500);

        include __DIR__ . '/../../view/exception.phtml';

        exit(static::EXIT_CODE);
    }
}
