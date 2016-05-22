<?php
/**
 *
 */

namespace Mvc5\Route;

use Mvc5\Arg;
use Mvc5\Http\Request as HttpRequest;

class Service
{
    /**
     * @var array|\ArrayAccess
     */
    protected $config;

    /**
     * @param array|\ArrayAccess $config
     */
    function __construct($config = [])
    {
        $this->config = $config;
    }

    /**
     * @param HttpRequest $request
     * @return HttpRequest
     */
    function __invoke(HttpRequest $request)
    {
        return $this->config[Arg::REQUEST] = $request;
    }
}
