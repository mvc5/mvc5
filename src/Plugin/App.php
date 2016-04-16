<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\App as _App;

class App
    extends Plugin
{
    /**
     * @param array|\ArrayAccess $config
     * @param $provider
     * @param $scope
     * @param array $calls
     */
    public function __construct($config = [], $provider = true, $scope = true, array $calls = [])
    {
        parent::__construct(_App::class, [$config, $provider === true ? new Link : $provider, $scope], $calls);
    }
}
