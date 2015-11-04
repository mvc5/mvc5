<?php
/**
 *
 */

namespace Mvc5\Response\Dispatch;

use Mvc5\Event\Event;
use Mvc5\Response\Response;
use Mvc5\Service\Resolver\EventSignal;

class Dispatch
    implements DispatchResponse, Event
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
     * @var Response
     */
    protected $response;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return array
     */
    protected function args()
    {
        return [
            Args::EVENT    => $this,
            Args::RESPONSE => $this->response
        ];
    }
}
