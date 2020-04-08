<?php
/**
 *
 */

namespace Mvc5\Http\Error;

use Mvc5\Http\HttpError;

use const Mvc5\{ DESCRIPTION, ERRORS, MESSAGE, STATUS };

final class ServerError
    extends HttpError
{
    /**
     * @param array $config
     */
    function __construct(array $config = [])
    {
        parent::__construct($config + [
            DESCRIPTION => 'The server encountered an unexpected condition which prevented it from fulfilling the request.',
            ERRORS => [],
            MESSAGE => 'Internal Server Error',
            STATUS => 500
        ]);
    }
}
