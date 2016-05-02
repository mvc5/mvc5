<?php
/**
 *
 */

namespace Mvc5\Response\Error;

use Mvc5\Arg;
use Mvc5\Response\Config\Error as Config;
use Mvc5\Response\Error;

class BadRequest
    implements Error
{
    /**
     *
     */
    use Config;

    /**
     * @param array $config
     */
    function __construct(array $config = [])
    {
        $this->config = $config + [
                Arg::DESCRIPTION => 'The server could not understand the request',
                Arg::ERRORS      => [],
                Arg::MESSAGE     => 'Bad Request',
                Arg::STATUS      => '400'
            ];
    }
}
