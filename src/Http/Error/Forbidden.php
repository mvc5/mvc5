<?php
/**
 *
 */

namespace Mvc5\Http\Error;

use Mvc5\Arg;
use Mvc5\Http\HttpError;

class Forbidden
    extends HttpError
{
    /**
     * @param array $config
     */
    function __construct(array $config = [])
    {
        parent::__construct($config + [
                Arg::DESCRIPTION => 'The server understood the request, but is refusing to fulfill it.',
                Arg::ERRORS => [],
                Arg::MESSAGE => 'Forbidden',
                Arg::STATUS => 403
            ]);
    }
}
