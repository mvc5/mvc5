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
use Mvc5\Response\Error;

class Dispatch
    implements Event
{
    /**
     *
     */
    use Signal;

    /**
     * @var Error
     */
    protected $error;

    /**
     * @var
     */
    protected $model;

    /**
     * @var HttpRequest
     */
    protected $request;

    /**
     * @var HttpResponse
     */
    protected $response;

    /**
     * @var int
     */
    protected $status;

    /**
     * @param $event
     * @param HttpRequest $request
     * @param HttpResponse $response
     */
    function __construct($event, HttpRequest $request = null, HttpResponse $response = null)
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
        return array_filter([
            Arg::ERROR    => $this->error,
            Arg::EVENT    => $this,
            Arg::MODEL    => $this->model,
            Arg::REQUEST  => $this->request,
            Arg::RESPONSE => $this->response,
            Arg::STATUS   => $this->status
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
            $this->request = $result;
            return $result;
        }

        if ($result instanceof HttpResponse) {
            $this->response = $result;
            return $result;
        }

        if ($result instanceof Error) {
            $this->error  = $result;
            $this->status = $result->status();
            return $result;
        }

        null !== $result &&
            $this->model = $result;

        return $result;
    }
}
