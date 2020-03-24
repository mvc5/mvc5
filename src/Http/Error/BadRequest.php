<?php
/**
 *
 */

namespace Mvc5\Http\Error;

use Mvc5\Http\HttpError;

use const Mvc5\{ DESCRIPTION, ERRORS, MESSAGE, STATUS };

class BadRequest
    extends HttpError
{
    /**
     * @param array $config
     */
    function __construct(array $config = [])
    {
        parent::__construct($config + [
            DESCRIPTION => 'The server could not understand the request.',
            ERRORS => [],
            MESSAGE => 'Bad Request',
            STATUS => 400
        ]);
    }
}
