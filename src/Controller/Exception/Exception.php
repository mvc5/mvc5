<?php
/**
 *
 */

namespace Mvc5\Controller\Exception;

use Mvc5\Event\Event;
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
     * @param Throwable $exception
     */
    public function __construct(Throwable $exception)
    {
        $this->exception = $exception;
    }

    /**
     * @return array
     */
    protected function args()
    {
        return [
            Args::EVENT     => $this,
            Args::EXCEPTION => $this->exception
        ];
    }
}
