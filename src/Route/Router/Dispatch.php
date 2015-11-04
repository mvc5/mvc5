<?php
/**
 *
 */

namespace Mvc5\Route\Router;

use Mvc5\Event\Base;
use Mvc5\Event\Event;
use Mvc5\Route\Route;
use Mvc5\Service\Resolver\Signal;

class Dispatch
    implements Event, RouteDispatch
{
    /**
     *
     */
    use Base;
    use Signal;

    /**
     *
     */
    const EVENT = self::DISPATCH;

    /**
     * @var Route $route
     */
    protected $route;

    /**
     * @param Route $route
     */
    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    /**
     * @return array
     */
    protected function args()
    {
        return [
            Args::EVENT => $this,
            Args::ROUTE => $this->route
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

        $result instanceof Route && $this->stop();

        return $result;
    }
}
