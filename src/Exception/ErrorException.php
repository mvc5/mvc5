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
     * @param $severity
     * @param $message
     * @param $file
     * @param $line
     * @return bool
     * @throws ErrorException|\ErrorException
     * @link http://php.net/manual/en/class.errorexception.php#variable.post.basic
     */
    static function handler($severity, $message, $file, $line)
    {
        return (error_reporting() & $severity) &&
            _Exception::errorException($message, 0, $severity, $file, $line);
    }
}
