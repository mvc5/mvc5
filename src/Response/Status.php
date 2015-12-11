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
    public function __construct($status)
    {
        $this->status = $status;
    }

    /**
     * @param Response $response
     * @return mixed
     */
    public function __invoke(Response $response)
    {
        $response->setStatus($this->status);
    }
}
