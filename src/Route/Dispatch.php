<?php
/**
 *
 */

namespace Mvc5\Route;

use Mvc5\Arg;
use Mvc5\Event\Event;
use Mvc5\Event\Signal;
use Mvc5\Http\Error as HttpError;
use Mvc5\Http\Request as HttpRequest;

class Dispatch
    implements Event
{
    /**
     *
     */
    use Signal;

    /**
     *
     */
    const EVENT = Arg::ROUTE_DISPATCH;

    /**
     * @var HttpError
     */
    protected $error;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @return array
     */
    protected function args()
    {
        return array_filter([
            Arg::ERROR   => $this->error,
            Arg::EVENT   => $this,
            Arg::REQUEST => $this->request
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

        $result instanceof HttpRequest
            && $this->request = $result;

        $result instanceof HttpError
            && $this->error = $result;

        return $result;
    }
}
