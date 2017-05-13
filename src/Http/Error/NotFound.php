<?php
/**
 *
 */

namespace Mvc5\Http\Error;

use Mvc5\Arg;
use Mvc5\Http\HttpError;

class NotFound
    extends HttpError
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
