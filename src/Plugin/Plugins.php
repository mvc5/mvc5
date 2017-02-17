<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;

class Plugins
    extends Plugin
{
    /**
     *
     */
    const APP_CLASS = 'Mvc5\App';

    /**
     * @param array|\ArrayAccess $services
     * @param $provider
     * @param $scope
     * @param array $calls
     */
    function __construct($services = [], $provider = true, $scope = true, array $calls = [])
    {
        parent::__construct(
            static::APP_CLASS, [$this->plugins($services, $provider), $provider === true ? new Link : $provider, $scope], $calls
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
