<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;
use Mvc5\App as _App;

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
            _App::class, [$this->plugins($services, $provider), $provider === true ? new Link : $provider, $scope], $calls
        );
    }

    /**
     * @param $services
     * @param $provider
     * @return Args
     */
    protected function plugins($services, $provider)
    {
        return new Args([Arg::SERVICES => $provider || !is_array($services) ? $services : new Args($services)]);
    }
}
