<?php
/**
 *
 */

namespace Mvc5\Http\Error;

use Mvc5\Http\HttpError;

use const Mvc5\{ DESCRIPTION, ERRORS, MESSAGE, STATUS };

final class MethodNotAllowed
    extends HttpError
{
    /**
     * @param array $config
     */
    function __construct(array $config = [])
    {
        parent::__construct($config + [
            DESCRIPTION => 'Unsupported resource request method.',
            ERRORS => [],
            MESSAGE => 'Method Not Allowed',
            STATUS => 405
        ]);
    }
}
