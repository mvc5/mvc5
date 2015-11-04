<?php
/**
 *
 */

namespace Mvc5\Controller\Dispatch;

use Mvc5\Event\Event;
use Mvc5\Service\Resolver\EventSignal;

class Dispatch
    implements Controller, Event
{
    /**
     *
     */
    use EventSignal;

    /**
     *
     */
    const EVENT = self::DISPATCH;

    /**
     * @var callable
     */
    protected $controller;

    /**
     * @param callable $controller
     */
    public function __construct(callable $controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return array
     */
    protected function args()
    {
        return [
            Args::EVENT      => $this,
            Args::CONTROLLER => $this->controller
        ];
    }
}
