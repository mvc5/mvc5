<?php
/**
 *
 */

namespace Mvc5\Exception;

use Mvc5\Arg;

class Runtime
    extends \RuntimeException
    implements Throwable
{
    /**
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     * @param array $backtrace
     */
    function __construct($message = '', $code = 0, \Exception $previous = null, array $backtrace = [])
    {
        parent::__construct($message, $code, $previous);

        $backtrace && isset($backtrace[Arg::FILE])
            && ($this->file = $backtrace[Arg::FILE]) && ($this->line = $backtrace[Arg::LINE]);
    }
}
