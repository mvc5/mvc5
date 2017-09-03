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
     * @param object|bool $provider
     * @param object|bool $scope
     * @param array $calls
     */
    function __construct($services = [], $provider = true, $scope = true, array $calls = [])
    {
        parent::__construct(
            static::APP_CLASS, [$this->plugins($services, (bool) $provider), $provider === true ? new Link : $provider, $scope], $calls
        );
    }

    /**
     * @param array|\ArrayAccess $services
     * @param bool $provider
     * @return Args
     */
    protected function plugins($services, bool $provider) : Args
    {
        return new Args([Arg::SERVICES => $provider || !is_array($services) ? $services : new Args($services)]);
    }
}
