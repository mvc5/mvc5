<?php
/**
 *
 */

namespace Mvc5\Response\Error;

use Mvc5\Arg;
use Mvc5\Response\Error;

class NotFound
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
                Arg::DESCRIPTION => 'The server can not find the requested resource',
                Arg::ERRORS      => [],
                Arg::MESSAGE     => 'Not Found',
                Arg::STATUS      => '404'
            ];
    }
}
