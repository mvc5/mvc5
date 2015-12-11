<?php
/**
 *
 */

namespace Mvc5\Route;

use Mvc5\Arg;
use Mvc5\Event\Event;
use Mvc5\Event\Signal;

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
     * @param callable $callable
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    public function __invoke(callable $callable, array $args = [], callable $callback = null)
    {
        $result = $this->signal($callable, $this->args() + $args, $callback);

        $result instanceof Route && $this->stop();

        return $result;
    }
}
