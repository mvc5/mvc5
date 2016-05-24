<?php
/**
 *
 */

namespace Mvc5\Controller;

use Mvc5\Arg;
use Mvc5\Event\Event;
use Mvc5\Event\Signal;
use Mvc5\Http\Request as HttpRequest;
use Mvc5\Http\Response as HttpResponse;

class Response
    implements Event
{
    /**
     *
     */
    use Signal;

    /**
     * @var HttpRequest
     */
    protected $request;

    /**
     * @var HttpResponse
     */
    protected $response;

    /**
     * @param string $event
     * @param HttpRequest $request
     * @param HttpResponse $response
     */
    function __construct($event, HttpRequest $request, HttpResponse $response)
    {
        $this->event    = $event;
        $this->request  = $request;
        $this->response = $response;
    }

    /**
     * @return array
     */
    protected function args()
    {
        return [
            Arg::CONTROLLER => $this->request[Arg::CONTROLLER],
            Arg::EVENT      => $this,
            Arg::MODEL      => $this->response[Arg::BODY],
            Arg::REQUEST    => $this->request,
            Arg::RESPONSE   => $this->response
        ];
    }

    /**
     * @param callable $callable
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    function __invoke(callable $callable, array $args = [], callable $callback = null)
    {
        $result = $this->signal($callable, $this->args() + $args, $callback);

        if ($result instanceof HttpRequest) {
            return $this->request = $result;
        }

        if ($result instanceof HttpResponse) {
            $this->stop();
            return $result;
        }

        null !== $result &&
            ($this->response[Arg::BODY] = $result);

        return $result;
    }
}
