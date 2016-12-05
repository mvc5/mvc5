<?php
/**
 *
 */

namespace Mvc5\Log;

use Mvc5\Arg;

class Error
{
    /**
     * @var null
     */
    protected $options = [];

    /**
     * @param array $options
     */
    function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * @param $message
     * @return bool
     */
    function __invoke($message)
    {
        return error_log(...array_values([Arg::MESSAGE => (string) $message] + $this->options));
    }
}
