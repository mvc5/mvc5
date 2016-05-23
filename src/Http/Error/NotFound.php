<?php
/**
 *
 */

namespace Mvc5\Http\Error;

use Mvc5\Arg;
use Mvc5\Http\Config\Error as Config;
use Mvc5\Http\Error;

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
                Arg::DESCRIPTION => 'The server can not find the requested resource.',
                Arg::ERRORS      => [],
                Arg::MESSAGE     => 'Not Found',
                Arg::STATUS      => '404'
            ];
    }
}
