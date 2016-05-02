<?php
/**
 *
 */

namespace Mvc5\Mvc\Event;

use Mvc5\Arg;
use Mvc5\Event\Signal;
use Mvc5\Response\Response;
use Mvc5\Route\Route;

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
        return $this->route()->controller();
    }

    /**
     * @param $model
     * @return array|callable|null|object|string
     */
    protected function model($model = null)
    {
        if (null !== $model) {
            $this->response()->setContent($model);
            return $model;
        }

        return $this->response()->content();
    }

    /**
     * @param Response $response
     * @return Response
     */
    protected function response(Response $response = null)
    {
        return null !== $response ? $this->config[Arg::RESPONSE] = $response : $this->config[Arg::RESPONSE];
    }

    /**
     * @param Route $route
     * @return Route
     */
    protected function route(Route $route = null)
    {
        return null !== $route ? $this->config[Arg::ROUTE] = $route : $this->config[Arg::ROUTE];
    }
}
