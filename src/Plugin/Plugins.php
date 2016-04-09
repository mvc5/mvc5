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
    public function __construct($services = [], $provider = null, $scope = null, array $calls = [])
    {
        parent::__construct(_Plugins::class, [new Args([Arg::SERVICES => $services]), $provider, $scope], $calls);
    }
}
