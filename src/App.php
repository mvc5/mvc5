<?php
/**
 *
 */

namespace Mvc5;

class App
    implements Service\Manager
{
    /**
     *
     */
    use Resolver\Resolver;

    /**
     * @param array|\ArrayAccess|Config\Configuration $config
     */
    public function __construct($config = null)
    {
        $config && $this->config = $config;

        isset($config[Arg::SERVICES][Arg::CONTAINER])
            && $this->container = $config[Arg::SERVICES][Arg::CONTAINER];

        isset($config[Arg::EVENTS])
            && $this->events = $config[Arg::EVENTS];

        isset($config[Arg::SERVICES])
            && $this->services = $config[Arg::SERVICES];
    }
}
