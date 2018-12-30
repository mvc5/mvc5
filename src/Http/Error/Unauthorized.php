<?php
/**
 *
 */

namespace Mvc5\Http\Error;

use Mvc5\Arg;
use Mvc5\Http\HttpError;

class Unauthorized
    extends HttpError
{
    /**
     * @param array $config
     */
    function __construct(array $config = [])
    {
        parent::__construct($config + [
                Arg::DESCRIPTION => '',
                Arg::ERRORS => [],
                Arg::MESSAGE => 'Unauthorized',
                Arg::STATUS => 401
            ]);
    }
}
