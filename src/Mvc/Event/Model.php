<?php
/**
 *
 */

namespace Mvc5\Mvc\Event;

use Mvc5\Arg;
use Mvc5\Config\Configuration;
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
     * @var Configuration
     */
    protected $config;

    /**
     * @param string $event
     * @param Configuration $config
     */
    public function __construct($event, Configuration $config)
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
     * @return array|callable|null|object|string
     */
    protected function model()
    {
        return $this->response()->content();
    }

    /**
     * @return Response
     */
    protected function response()
    {
        return $this->config->get(Arg::RESPONSE);
    }

    /**
     * @return Route
     */
    protected function route()
    {
        return $this->config->get(Arg::ROUTE);
    }

    /**
     * @param $model
     * @return void
     */
    protected function setModel($model)
    {
        $this->response()->setContent($model);
    }

    /**
     * @param Response $response
     * @return void
     */
    protected function setResponse(Response $response)
    {
        $this->config->set(Arg::RESPONSE, $response);
    }

    /**
     * @param Route $route
     * @return void
     */
    protected function setRoute(Route $route)
    {
        $this->config->set(Arg::ROUTE, $route);
    }
}
