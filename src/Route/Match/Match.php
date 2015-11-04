<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Event\Base;
use Mvc5\Event\Event;
use Mvc5\Route\Definition\Definition;
use Mvc5\Route\Route;
use Mvc5\Service\Resolver\Signal;

class Match
    implements Event, RouteMatch
{
    /**
     *
     */
    use Base;
    use Signal;

    /**
     *
     */
    const EVENT = self::ROUTE;

    /**
     * @var Definition
     */
    protected $definition;

    /**
     * @var Route
     */
    protected $route;

    /***
     * @param Definition $definition
     * @param Route $route
     */
    public function __construct(Definition $definition, Route $route)
    {
        $this->definition = $definition;
        $this->route      = $route;
    }

    /**
     * @return array
     */
    protected function args()
    {
        return [
            Args::EVENT      => $this,
            Args::DEFINITION => $this->definition,
            Args::ROUTE      => $this->route
        ];
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

        !$result && $this->stop();

        $result instanceof Route && $this->route = $result;

        return $result;
    }
}
