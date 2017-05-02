<?php
/**
 *
 */

namespace Mvc5\Http\Error;

use Mvc5\Arg;
use Mvc5\Http\Config\Error;
use Mvc5\Http\Error as HttpError;

class BadRequest
    implements HttpError
{
    /**
     *
     */
    use Error;

    /**
     * @param array $config
     */
    function __construct(array $config = [])
    {
        $this->config = $config + [
                Arg::DESCRIPTION => 'The server could not understand the request.',
                Arg::ERRORS      => [],
                Arg::MESSAGE     => 'Bad Request',
                Arg::STATUS      => '400'
            ];
    }
}
