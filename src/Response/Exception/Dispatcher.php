<?php
/**
 *
 */

namespace Mvc5\Response\Exception;

use Mvc5\Response\Response;

class Dispatcher
    implements Dispatch
{
    /**
     * @var
     */
    protected $status;

    /**
     * @param int $status
     */
    public function __construct($status)
    {
        $this->status = $status;
    }

    /**
     * @param Response $response
     * @return Response
     */
    public function __invoke(Response $response)
    {
        $response->setStatus($this->status);
        return $response;
    }
}
