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
     * @var Route
     */
    protected $route;

    /**
     * @var Request
     */
    protected $request;

    /***
     * @param Route $route
     * @param Request $request
     */
    function __construct(Route $route, Request $request)
    {
        $this->route   = $route;
        $this->request = $request;
    }

    /**
     * @return array
     */
    protected function args()
    {
        return [
            Arg::EVENT   => $this,
            Arg::ROUTE   => $this->route,
            Arg::REQUEST => $this->request
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

        if (!$result instanceof Request) {
            $this->stop();
            return $result;
        }

        return $this->request = $result;
    }
}
