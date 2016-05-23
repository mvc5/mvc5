<?php
/**
 *
 */

namespace Mvc5;

use Throwable;

class Web
{
    /**
     * @var App
     */
    protected $app;

    /**
     * @param array|\ArrayAccess|Config\Configuration $config
     * @param callable|Resolvable $provider
     * @param bool|object|Resolvable $scope
     */
    function __construct($config = null, $provider = null, $scope = null)
    {
        $this->app = new App($config, $provider, $scope);
    }

    /**
     * @return callable|mixed|null|object
     */
    function __invoke()
    {
        try {

            return $this->app->call(Arg::WEB);

        } catch(Throwable $exception) {

            return $this->app->call(Arg::EXCEPTION_RESPONSE, [Arg::EXCEPTION => $exception]);
        }
    }
}
