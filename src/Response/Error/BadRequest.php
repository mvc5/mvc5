<?php
/**
 *
 */

namespace Mvc5\Response\Error;

use Mvc5\Arg;
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
    public function __construct(array $config = [])
    {
        $this->config = $config + [
                Arg::DESCRIPTION => 'The server could not understand the request',
                Arg::ERRORS      => [],
                Arg::MESSAGE     => 'Bad Request',
                Arg::STATUS      => '400'
            ];
    }
}
