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
        return $this->signal('error_log', [Arg::MESSAGE => (string) $message] + $this->options);
    }
}
