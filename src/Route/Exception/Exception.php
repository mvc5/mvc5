<?php
/**
 *
 */

namespace Mvc5\Route\Exception;

use Mvc5\Event\Event;
use Mvc5\Route\Route;
use Mvc5\Service\Resolver\EventSignal;
use Throwable;

class Exception
    implements DispatchException, Event
{
    /**
     *
     */
    use EventSignal;

    /**
     *
     */
    const EVENT = self::EXCEPTION;

    /**
     * @var Throwable
     */
    protected $exception;

    /**
     * @var Route
     */
    protected $route;

    /**
     * @param Route $route
     * @param Throwable $exception
     */
    public function __construct(Route $route, Throwable $exception)
    {
        $this->exception = $exception;
        $this->route     = $route;
    }

    /**
     * @return array
     */
    protected function args()
    {
        return [
            Args::EVENT     => $this,
            Args::EXCEPTION => $this->exception,
            Args::ROUTE     => $this->route
        ];
    }
}
