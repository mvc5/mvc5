<?php
/**
 *
 */

namespace Mvc5\Http\Error;

use Mvc5\Arg;

class MethodNotAllowed
    extends Error
{
    /**
     * @param array $config
     */
    function __construct(array $config = [])
    {
        parent::__construct($config + [
            Arg::DESCRIPTION => 'Unsupported resource request method.',
            Arg::ERRORS => [],
            Arg::MESSAGE => 'Method Not Allowed',
            Arg::STATUS => 405
        ]);
    }
}
