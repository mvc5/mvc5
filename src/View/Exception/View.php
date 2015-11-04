<?php
/**
 *
 */

namespace Mvc5\View\Exception;

use Mvc5\Event\Event;
use Mvc5\Service\Resolver\EventSignal;
use Mvc5\View\ViewModel;
use Throwable;

class View
    implements Event, ViewException
{
    /**
     *
     */
    use EventSignal;
    use ViewModel;

    /**
     *
     */
    const EVENT = self::VIEW;

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
            Args::EVENT      => $this,
            Args::EXCEPTION  => $this->exception,
            Args::MODEL      => $this->model()
        ];
    }
}
