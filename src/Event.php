<?php
/**
 *
 */

namespace Mvc5;

class Event
    implements Event\Event
{
    /**
     *
     */
    use Event\EventModel;

    /**
     * @var mixed
     */
    protected $model;

    /**
     * @param string|null $event
     * @param mixed $model
     */
    function __construct($event = null, $model = null)
    {
        $this->event = $event;
        $this->model = $model;
    }

    /**
     * @return array
     */
    protected function args()
    {
        return array_filter([
            Arg::EVENT => $this,
            Arg::MODEL => $this->model
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
        $model = $this->signal(
            $callable, !$args ? $this->args() : (!is_string(key($args)) ? $args : $this->args() + $args), $callback
        );

        null !== $model
            && $this->model = $model;

        return $model;
    }
}
