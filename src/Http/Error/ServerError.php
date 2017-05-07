<?php
/**
 *
 */

namespace Mvc5\Http\Error;

use Mvc5\Arg;

class ServerError
    extends Error
{
    /**
     * @param array $config
     */
    function __construct(array $config = [])
    {
        parent::__construct($config + [
            Arg::DESCRIPTION => 'The server encountered an unexpected condition which prevented it from fulfilling the request.',
            Arg::ERRORS => [],
            Arg::MESSAGE => 'Internal Server Error',
            Arg::STATUS => 500
        ]);
    }
}
