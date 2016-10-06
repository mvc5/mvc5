<?php
/**
 *
 */

namespace Mvc5\Route;

use Mvc5\Arg;
use Mvc5\Event\Event;
use Mvc5\Event\Signal;

class Match
    implements Event
{
    /**
     *
     */
    use Signal;

    /**
     *
     */
    const EVENT = Arg::ROUTE_MATCH;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Route
     */
    protected $route;

    /***
     * @param Route $route
     * @param Request $request
     */
    function __construct(Route $route, Request $request)
    {
        $this->request = $request;
        $this->route   = $route;
    }

    /**
     * @return array
     */
    protected function args()
    {
        return [
            Arg::EVENT   => $this,
            Arg::REQUEST => $this->request,
            Arg::ROUTE   => $this->route
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
        $result = $this->signal($callable, $this->args() + $args, $callback);

        return !$result instanceof Request && $this->stop() ? $result : $this->request = $result;
    }
}
