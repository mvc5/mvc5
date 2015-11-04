<?php
/**
 *
 */

namespace Mvc5\Application;

use Mvc5\Event\Manager\EventManager;
use Mvc5\Service\Manager\ServiceManager;

interface Application
    extends EventManager, ServiceManager
{
}
