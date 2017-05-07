<?php
/**
 *
 */

namespace Mvc5\Http\Error;

use Mvc5\Arg;

class NotFound
    extends Error
{
    /**
     * @param array $config
     */
    function __construct(array $config = [])
    {
        parent::__construct($config + [
            Arg::DESCRIPTION => 'The server can not find the requested resource.',
            Arg::ERRORS => [],
            Arg::MESSAGE => 'Not Found',
            Arg::STATUS => 404
        ]);
    }
}
