<?php
/**
 *
 */

namespace Mvc5\Plugin;

class App
    extends Plugin
{
    /**
     *
     */
    const APP_CLASS = 'Mvc5\App';

    /**
     * @param array|\ArrayAccess $config
     * @param bool|callable $provider
     * @param bool|object $scope
     * @param array $calls
     */
    function __construct($config = [], $provider = true, $scope = true, array $calls = [])
    {
        parent::__construct(static::APP_CLASS, [$config, $provider === true ? new Link : $provider, $scope], $calls);
    }
}
