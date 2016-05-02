<?php
/**
 *
 */

namespace Mvc5\Response;

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
     * @param Response $response
     * @return mixed
     */
    function __invoke(Response $response)
    {
        return $response->setStatus($this->status);
    }
}
