<?php
/**
 *
 */

namespace Mvc5\Response;

use Mvc5\Arg;
use Throwable;

trait Sender
{
    /**
     * @param array|callable|object|string $name
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     */
    protected abstract function call($name, array $args = [], callable $callback = null);

    /**
     * @param Throwable $exception
     * @param $response
     * @return Response
     */
    protected function exception(Throwable $exception, $response)
    {
        return $this->call(Arg::RESPONSE_EXCEPTION, [Arg::EXCEPTION => $exception, Arg::RESPONSE => $response]);
    }

    /**
     * @param $response
     * @return mixed
     */
    protected function send($response)
    {
        return $this->call(Arg::RESPONSE_DISPATCH, [Arg::RESPONSE => $response]);
    }
}
