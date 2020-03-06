<?php
/**
 *
 */

namespace Mvc5\Response;

use Mvc5\Http\Error;

class JsonErrorResponse
    extends JsonResponse
{
    /**
     * @param Error $error
     * @throws \Throwable
     */
    function __construct(Error $error)
    {
        parent::__construct($error, $error->status());
    }
}
