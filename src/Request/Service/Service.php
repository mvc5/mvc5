<?php
/**
 *
 */

namespace Mvc5\Request\Service;

use Mvc5\Arg;
use Mvc5\Config\Configuration;
use Mvc5\Http\Request as HttpRequest;

trait Service
{
    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @param Configuration $config
     */
    function __construct(Configuration $config)
    {
        $this->config = $config;
    }

    /**
     * @param HttpRequest $request
     * @return HttpRequest
     */
    protected function service(HttpRequest $request)
    {
        return $this->config[Arg::REQUEST] = $request;
    }

    /**
     * @param HttpRequest $request
     * @return HttpRequest
     */
    function __invoke(HttpRequest $request)
    {
        return $this->service($request);
    }
}
