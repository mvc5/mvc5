<?php
/**
 *
 */

namespace Mvc5\Exception;

class ErrorException
    extends \ErrorException
    implements Throwable
{
    /**
     *
     */
    use Exception;

    /**
     * @param int $severity
     * @param string $message
     * @param string $file
     * @param int $line
     * @return bool
     * @codeCoverageIgnore
     */
    static function handler(int $severity, string $message, string $file, int $line)
    {
        if (!ini_get('display_errors') ||
            in_array($severity, [E_DEPRECATED, E_USER_DEPRECATED]) || 'cli' === php_sapi_name()) {
            return false;
        }

        $success = true;
        while(ob_get_level() && $success) {
            $success = ob_end_clean();
        }

        http_response_code(500);

        $exception = new self($message, 0, $severity, $file, $line);

        include __DIR__ . '/../../view/exception.phtml';

        exit(70);
    }
}
