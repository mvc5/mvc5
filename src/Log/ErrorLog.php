<?php
/**
 *
 */

namespace Mvc5\Log;

use function error_log;

class ErrorLog
{
    /**
     * @var string
     */
    protected string $destination = '';

    /**
     * @var string
     */
    protected string $extra_headers = '';

    /**
     * @var int
     */
    protected int $message_type = 0;

    /**
     * @param int $message_type
     * @param string $destination
     * @param string $extra_headers
     */
    function __construct(int $message_type = 0, string $destination = '', string $extra_headers = '')
    {
        $this->destination   = $destination;
        $this->extra_headers = $extra_headers;
        $this->message_type  = $message_type;
    }

    /**
     * @param $message
     * @return bool
     */
    function __invoke($message) : bool
    {
        return error_log((string) $message, $this->message_type, $this->destination, $this->extra_headers);
    }
}
