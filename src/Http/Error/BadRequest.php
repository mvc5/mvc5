<?php
/**
 *
 */

namespace Mvc5\Http\Error;

use Mvc5\Arg;

class BadRequest
    extends Error
{
    /**
     * @param array $config
     */
    function __construct(array $config = [])
    {
        parent::__construct($config + [
            Arg::DESCRIPTION => 'The server could not understand the request.',
            Arg::ERRORS => [],
            Arg::MESSAGE => 'Bad Request',
            Arg::STATUS => 400
        ]);
    }
}
