<?php
/**
 *
 */

namespace Mvc5\Application;

use Mvc5\Config\Configuration;
use Mvc5\Event\Manager\Events;

class App
    implements Application
{
    /**
     *
     */
    use Events;

    /**
     * @param array|Configuration $config
     */
    public function __construct($config)
    {
        $this->alias     = $config[Args::ALIAS];
        $this->config    = $config;
        $this->container = $config[Args::SERVICES][Args::CONTAINER];
        $this->events    = $config[Args::EVENTS];
        $this->services  = $config[Args::SERVICES];
    }
}
