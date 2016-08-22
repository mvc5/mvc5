<?php
/**
 *
 */

namespace Mvc5\Event;

use Mvc5\Arg;
use Mvc5\Signal as _Signal;

trait Signal
{
    /**
     *
     */
    use Model;
    use _Signal;

    /**
     * @return array
     */
    protected function args()
    {
        return [
            Arg::EVENT => $this
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
        return $this->signal(
            $callable, !$args ? $this->args() : (!is_string(key($args)) ? $args : $this->args() + $args), $callback
        );
    }
}
