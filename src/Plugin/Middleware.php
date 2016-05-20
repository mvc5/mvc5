<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;
use Mvc5\Http\Request as HttpRequest;
use Mvc5\Http\Response as HttpResponse;
use Mvc5\Service\Service as _Service;

class Middleware
    extends Call
{
    /**
     * @param $config
     */
    function __construct($config)
    {
        parent::__construct([$this, 'next'], [new Link, $config]);
    }

    /**
     * @param _Service $service
     * @param $config
     * @return \Closure
     */
    function next(_Service $service, $config)
    {
        return function($request, $response, $next) use ($service, $config) {
            $result = $service->call($config, [Arg::REQUEST => $request, Arg::RESPONSE => $response]);

            if ($result instanceof HttpRequest) {
                return $next($result, $response);
            }

            if ($result instanceof HttpResponse) {
                return $next($request, $result);
            }

            return $next($request, $response);
        };
    }
}
