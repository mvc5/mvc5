<?php
/**
 *
 */

namespace Mvc5\Response\Manager;

use Mvc5\Response\Response;
use Throwable;

trait ManageResponse
{
    /**
     * @var ResponseManager
     */
    protected $rm;

    /**
     * @param Response $response
     * @param Throwable $exception
     * @return Response
     */
    public function exception(Response $response, Throwable $exception)
    {
        return $this->rm->exception($response, $exception);
    }

    /**
     * @param Response $response
     * @return mixed
     */
    public function send(Response $response)
    {
        return $this->rm->send($response);
    }

    /**
     * @param  ResponseManager $rm
     */
    public function setResponseManager(ResponseManager $rm)
    {
        $this->rm = $rm;
    }

    /**
     * @return ResponseManager
     */
    public function responseManager()
    {
        return $this->rm;
    }
}
