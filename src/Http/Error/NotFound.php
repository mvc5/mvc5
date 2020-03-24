<?php
/**
 *
 */

namespace Mvc5\Http\Error;

use Mvc5\Http\HttpError;

use const Mvc5\{ DESCRIPTION, ERRORS, MESSAGE, STATUS };

class NotFound
    extends HttpError
{
    /**
     * @param array $config
     */
    function __construct(array $config = [])
    {
        parent::__construct($config + [
            DESCRIPTION => 'The server can not find the requested resource.',
            ERRORS => [],
            MESSAGE => 'Not Found',
            STATUS => 404
        ]);
    }
}
