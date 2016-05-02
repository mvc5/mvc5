<?php
/**
 *
 */

namespace Mvc5\Mvc\Event;

use Mvc5\Arg;
use Mvc5\Event\Signal;
use Mvc5\Http\Response;
use Mvc5\Http\Request;

trait Model
{
    /**
     *
     */
    use Signal;

    /**
     * @var array|\ArrayAccess
     */
    protected $config;

    /**
     * @var mixed
     */
    protected $model;

    /**
     * @param $event
     * @param array|\ArrayAccess $config
     */
    function __construct($event, $config)
    {
        $this->config = $config;
        $this->event  = $event;
    }

    /**
     * @return callable|object|null|string
     */
    protected function controller()
    {
        return $this->config[Arg::REQUEST][Arg::CONTROLLER];
    }

    /**
     * @param $model
     * @return array|callable|null|object|string
     */
    protected function model($model = null)
    {
        return func_num_args() ? $this->config[Arg::RESPONSE][Arg::BODY] = $model
            : $this->config[Arg::RESPONSE][Arg::BODY];
    }

    /**
     * @param Request $request
     * @return Request
     */
    protected function request(Request $request = null)
    {
        return null !== $request ? $this->config[Arg::REQUEST] = $request : $this->config[Arg::REQUEST];
    }

    /**
     * @param Response $response
     * @return Response
     */
    protected function response(Response $response = null)
    {
        return null !== $response ? $this->config[Arg::RESPONSE] = $response : $this->config[Arg::RESPONSE];
    }
}
