<?php
/**
 *
 */

namespace Mvc5\Response;

use Mvc5\Arg;
use Mvc5\Event\Event;
use Mvc5\Event\EventModel;
use Mvc5\Http\Request;
use Mvc5\Http\Response;

use function array_filter;

class Dispatch
    implements Event
{
    /**
     *
     */
    use EventModel;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @param string $event
     * @param Request|null $request
     * @param Response|null $response
     */
    function __construct(string $event, Request $request = null, Response $response = null)
    {
        $this->event = $event;
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return array
     */
    protected function args() : array
    {
        return array_filter([
            Arg::CONTROLLER => $this->request[Arg::CONTROLLER],
            Arg::EVENT      => $this,
            Arg::MODEL      => $this->response[Arg::BODY],
            Arg::REQUEST    => $this->request,
            Arg::RESPONSE   => $this->response
        ]);
    }

    /**
     * @param callable $callable
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     * @throws \Throwable
     */
    function __invoke(callable $callable, array $args = [], callable $callback = null)
    {
        $result = $this->signal($callable, $this->args() + $args, $callback);

        if ($result instanceof Request) {
            return $this->request = $result;
        }

        if ($result instanceof Response) {
            return $this->response = $result;
        }

        null !== $result &&
            $this->response = $this->response->with(Arg::BODY, $result);

        return $result;
    }
}
