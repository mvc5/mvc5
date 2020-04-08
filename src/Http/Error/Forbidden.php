<?php
/**
 *
 */

namespace Mvc5\Http\Error;

use Mvc5\Http\HttpError;

use const Mvc5\{ DESCRIPTION, ERRORS, MESSAGE, STATUS };

final class Forbidden
    extends HttpError
{
    /**
     * @param array $config
     */
    function __construct(array $config = [])
    {
        parent::__construct($config + [
                DESCRIPTION => 'The server understood the request, but is refusing to fulfill it.',
                ERRORS => [],
                MESSAGE => 'Forbidden',
                STATUS => 403
            ]);
    }
}
