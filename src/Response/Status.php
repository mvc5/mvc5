<?php
/**
 *
 */

namespace Mvc5\Response;

use Mvc5\Arg;

class Status
{
    /**
     * @var
     */
    protected $status;

    /**
     * @param $status
     */
    function __construct($status)
    {
        $this->status = $status;
    }

    /**
     * @param array|\ArrayAccess $response
     * @return mixed
     */
    function __invoke($response)
    {
        $response[Arg::STATUS] = $this->status;

        return $response;
    }
}
