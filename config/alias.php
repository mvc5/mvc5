<?php
/**
 *
 */

use Mvc5\Service\Config\Dependency\Dependency;
use Mvc5\Service\Config\Service\Service;

return [
    'config'           => new Dependency('Config'),
    'event:create'     => new Dependency('Service\Event\Create'),
    'layout'           => new Dependency('Layout'),
    'request'          => new Dependency('Request'),
    'response'         => new Dependency('Response'),
    'route:definition' => new Dependency('Route\Definition'),
    'route:exception'  => new Service('Route\Exception\Create'),
    'service:provider' => new Dependency('Service\Provider'),
    'sm'               => new Dependency('Service\Manager'),
    'url'              => new Dependency('Route\Plugin'),
    'web'              => new Service('Mvc'),
    'vm'               => new Dependency('View\Manager')
];
