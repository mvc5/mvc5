<?php
/**
 *
 */

namespace Mvc5\Event;

use Mvc5\Arg;
use Mvc5\Signal;

trait EventModel
{
    /**
     *
     */
    use Model;

    /**
     * @return array
     */
    protected function args() : array
    {
        return [
            Arg::EVENT => $this
        ];
    }

    /**
     * @param callable $callable
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     */
    protected function signal(callable $callable, array $args = [], callable $callback = null)
    {
        return Signal::emit($callable, $args, $callback);
    }

    /**
     * @param callable $callable
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     */
    function __invoke(callable $callable, array $args = [], callable $callback = null)
    {
        return $this->signal(
            $callable, !$args ? $this->args() : (!is_string(key($args)) ? $args : $this->args() + $args), $callback
        );
    }
}
