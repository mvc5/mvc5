<?php
/**
 *
 */

namespace Mvc5\Response;

use Mvc5\Arg;
use Mvc5\Event\Event;
use Mvc5\Event\Signal;
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
     * @var Response
     */
    protected $response;

    /**
     * @var int
     */
    protected $status;

    /**
     * @param $event
     * @param Response $response
     */
    public function __construct($event, Response $response = null)
    {
        $this->event    = $event;
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
    public function __invoke(callable $callable, array $args = [], callable $callback = null)
    {
        $response = $this->signal($callable, $this->args() + $args, $callback);

        if ($response instanceof Response) {
            $this->response = $response;
            return $response;
        }

        if ($response instanceof Error) {
            $this->error  = $response;
            $this->status = $response->status();
            return $response;
        }

        null !== $response &&
            $this->model = $response;

        return $response;
    }
}
