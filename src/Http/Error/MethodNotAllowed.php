<?php
/**
 *
 */

namespace Mvc5\Http\Error;

use Mvc5\Arg;
use Mvc5\Http\Config\Error;
use Mvc5\Http\Error as HttpError;

class MethodNotAllowed
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
                Arg::DESCRIPTION => 'Unsupported resource request method.',
                Arg::ERRORS      => [],
                Arg::MESSAGE     => 'Method Not Allowed',
                Arg::STATUS      => '405'
        ];
    }
}
