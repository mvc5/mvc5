<?php
/**
 *
 */

namespace Mvc5\Log;

use Mvc5\Arg;
use Mvc5\Event\Event;
use Mvc5\Event\EventModel;

class Logger
    implements Event
{
    /**
     *
     */
    use EventModel;

    /**
     *
     */
    const EVENT = 'log';

    /**
     * @var bool|false
     */
    protected $throw_exception = false;

    /**
     * @var mixed|\Exception
     */
    protected $message;

    /**
     * @param bool|false $throw_exception
     */
    function __construct(bool $throw_exception = false)
    {
        $this->throw_exception = $throw_exception;
    }

    /**
     * @return array
     */
    protected function args()
    {
        return array_filter([
            Arg::EVENT           => $this,
            Arg::MESSAGE         => $this->message,
            Arg::THROW_EXCEPTION => $this->throw_exception
        ]);
    }

    /**
     * @param callable $callable
     * @param array $args
     * @param callable|null $callback
     * @return mixed
     */
    function __invoke(callable $callable, array $args = [], callable $callback = null)
    {
        $result = $this->signal($callable, $this->args() + $args, $callback);

        $result && !is_bool($result) &&
            $this->message = $result;

        return $result;
    }
}
