<?php
/**
 *
 */

namespace Mvc5\Response\Manager;

use Mvc5\Event\Manager\EventManager;
use Mvc5\Event\Manager\Events;
use Mvc5\Response\Exception\ResponseException;
use Mvc5\Response\Dispatch\DispatchResponse;
use Mvc5\Response\Response;
use Mvc5\Service\Manager\ServiceManager;
use Throwable;

class Manager
    implements EventManager, ResponseManager, ServiceManager
{
    /**
     *
     */
    use Events;

    /**
     * @param Response $response
     * @param Throwable $exception
     * @return Response
     */
    public function exception(Response $response, Throwable $exception)
    {
        return $this->trigger([ResponseException::EXCEPTION, Args::RESPONSE => $response, Args::EXCEPTION => $exception], [], $this);
    }

    /**
     * @param Response $response
     * @return mixed
     */
    public function send(Response $response)
    {
        return $this->trigger([DispatchResponse::DISPATCH, Args::RESPONSE => $response], [], $this);
    }
}
