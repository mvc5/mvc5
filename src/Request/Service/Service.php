<?php
/**
 *
 */

namespace Mvc5\Request\Service;

use Mvc5\Arg;
use Mvc5\Config\Configuration;
use Mvc5\Http\Request;

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
     * @param Request $request
     * @return Request
     */
    protected function service(Request $request)
    {
        return $this->config[Arg::REQUEST] = $request;
    }

    /**
     * @param Request $request
     * @return Request
     */
    function __invoke(Request $request)
    {
        return $this->service($request);
    }
}
