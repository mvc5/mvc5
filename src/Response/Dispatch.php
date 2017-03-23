<?php
/**
 *
 */

namespace Mvc5\Response;

use Mvc5\Arg;
use Mvc5\Event\Event;
use Mvc5\Event\Signal;
use Mvc5\Http\Request as HttpRequest;
use Mvc5\Http\Response as HttpResponse;

class Dispatch
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
     * @param $event
     * @param HttpRequest $request
     * @param HttpResponse $response
     */
    function __construct($event, HttpRequest $request = null, HttpResponse $response = null)
    {
        $this->event = $event;

        $request && $this->request = $request;

        $response && $this->response = $response;
    }

    /**
     * @return array
     */
    protected function args()
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
            return $this->response = $result;
        }

        null !== $result &&
            $this->response = $this->response->with(Arg::BODY, $result);

        return $result;
    }
}
