<?php
/**
 *
 */

namespace Mvc5\Http\Error;

use Mvc5\Http\HttpError;

use const Mvc5\{ DESCRIPTION, ERRORS, MESSAGE, STATUS };

class Unauthorized
    extends HttpError
{
    /**
     * @param array $config
     */
    function __construct(array $config = [])
    {
        parent::__construct($config + [
                DESCRIPTION => '',
                ERRORS => [],
                MESSAGE => 'Unauthorized',
                STATUS => 401
            ]);
    }
}
