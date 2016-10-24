<?php
/**
 *
 */

namespace Mvc5\Log;

use Mvc5\Arg;
use Mvc5\Signal;

class Error
{
    /**
     *
     */
    use Signal;

    /**
     * @var null
     */
    protected $options = [];

    /**
     * @var bool|false
     */
    protected $throw_exceptions = false;

    /**
     * @param bool|false $throw_exceptions
     * @param array $options
     */
    function __construct($throw_exceptions = false, array $options = [])
    {
        $throw_exceptions && $this->throw_exceptions = $throw_exceptions;
        $options && $this->options = $options;
    }

    /**
     * @param $message
     * @return bool
     * @throws \Throwable
     */
    function __invoke($message)
    {
        if ($this->throw_exceptions && $message instanceof \Throwable) {
            throw $message;
        }

        return $this->signal('error_log', [Arg::MESSAGE => (string) $message] + $this->options);
    }
}
