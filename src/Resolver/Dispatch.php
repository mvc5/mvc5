<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Mvc5\Arg;
use Mvc5\Event\Event;
use Mvc5\Event\EventModel;
use Mvc5\Resolvable;

class Dispatch
    implements Event
{
    /**
     *
     */
    use EventModel;

    /**
     *
     */
    const EVENT = Arg::SERVICE_RESOLVER;

    /**
     * @param callable $callable
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    function __invoke(callable $callable, array $args = [], callable $callback = null)
    {
        $result = $this->signal($callable, is_string(key($args)) ? $this->args() + $args : $args, $callback);

        null !== $result && !$result instanceof Resolvable && $this->stop();

        return $result;
    }
}
