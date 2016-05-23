<?php
/**
 *
 */

namespace Mvc5\Http\Error;

use Mvc5\Arg;
use Mvc5\Http\Config\Error as Config;
use Mvc5\Http\Error;

class ServerError
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
                Arg::DESCRIPTION => 'The server encountered an unexpected condition which prevented it from fulfilling the request.',
                Arg::ERRORS      => [],
                Arg::MESSAGE     => 'Internal Server Error',
                Arg::STATUS      => '500'
            ];
    }
}
