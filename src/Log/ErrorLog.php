<?php
/**
 *
 */

namespace Mvc5\Log;

class ErrorLog
{
    /**
     * @var string
     */
    protected $destination = '';

    /**
     * @var string
     */
    protected $extra_headers = '';

    /**
     * @var int
     */
    protected $message_type = 0;

    /**
     * @param int $message_type
     * @param string $destination
     * @param string $extra_headers
     */
    function __construct($message_type = 0, $destination = '', $extra_headers = '')
    {
        $this->destination   = $destination;
        $this->extra_headers = $extra_headers;
        $this->message_type  = $message_type;
    }

    /**
     * @param $message
     * @return bool
     */
    function __invoke($message)
    {
        return error_log((string) $message, $this->message_type, $this->destination, $this->extra_headers);
    }
}
