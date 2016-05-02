<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;
use Mvc5\Plugins as _Plugins;

class Plugins
    extends Plugin
{
    /**
     * @param array|\ArrayAccess $services
     * @param $provider
     * @param $scope
     * @param array $calls
     */
    function __construct($services = [], $provider = true, $scope = true, array $calls = [])
    {
        parent::__construct(
            _Plugins::class,
            [new Args([Arg::SERVICES => $services]), $provider === true ? new Link : $provider, $scope],
            $calls
        );
    }
}
