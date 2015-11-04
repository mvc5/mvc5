<?php
/**
 *
 */

namespace Mvc5\Mvc;

use Mvc5\Config\Configuration;
use Mvc5\Event\Base as Event;
use Mvc5\Response\Response;
use Mvc5\Route\Route;
use Mvc5\Service\Resolver\Signal;

trait Base
{
    /**
     *
     */
    use Event;
    use Signal;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @param Configuration $config
     */
    public function __construct(Configuration $config)
    {
        $this->config = $config;
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
        return $this->config->get(Dispatch::RESPONSE);
    }

    /**
     * @return Route
     */
    protected function route()
    {
        return $this->config->get(Dispatch::ROUTE);
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
        $this->config->set(Dispatch::RESPONSE, $response);
    }

    /**
     * @param Route $route
     * @return void
     */
    protected function setRoute(Route $route)
    {
        $this->config->set(Dispatch::ROUTE, $route);
    }
}
