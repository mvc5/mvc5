<?php
/**
 *
 */

namespace Mvc5\Route;

use Mvc5\Arg;
use Mvc5\Event\Event;
use Mvc5\Event\Signal;
use Mvc5\Response\Error;
use Mvc5\Response\Response;

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
     * @var Error
     */
    protected $error;

    /**
     * @var int
     */
    protected $status;

    /**
     * @return array
     */
    protected function args()
    {
        return array_filter([
            Arg::ERROR  => $this->error,
            Arg::EVENT  => $this,
            Arg::STATUS => $this->status
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
        $result = $this->signal($callable, $this->args() + $args, $callback);

        ($result instanceof Route || $result instanceof Response) && $this->stop();

        if ($result instanceof Error) {
            $this->error  = $result;
            $this->status = $result->status();
        }

        return $result;
    }
}
