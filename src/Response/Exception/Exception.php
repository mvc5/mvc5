<?php
/**
 *
 */

namespace Mvc5\Response\Exception;

use Mvc5\Event\Base;
use Mvc5\Event\Event;
use Mvc5\Response\Response;
use Mvc5\Service\Resolver\Signal;
use Throwable;

class Exception
    implements ResponseException, Event
{
    /**
     *
     */
    use Base;
    use Signal;

    /**
     *
     */
    const EVENT = self::EXCEPTION;

    /**
     * @var Throwable
     */
    protected $exception;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @param Response $response
     * @param Throwable $exception
     */
    public function __construct(Response $response, Throwable $exception)
    {
        $this->exception = $exception;
        $this->response  = $response;
    }

    /**
     * @return array
     */
    protected function args()
    {
        return [
            Args::EVENT     => $this,
            Args::EXCEPTION => $this->exception,
            Args::RESPONSE  => $this->response,
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
        $response = $this->signal($callable, $this->args() + $args, $callback);

        $response instanceof Response && $this->response = $response;

        return $response;
    }
}
