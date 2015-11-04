<?php
/**
 *
 */

namespace Mvc5;

use Mvc5\Service\Config\Args\Args;
use Mvc5\Service\Config\Call\Call;
use Mvc5\Service\Config\ConfigLink\ConfigLink;
use Mvc5\Service\Config\Dependency\Dependency;
use Mvc5\Service\Config\Hydrator\Hydrator;
use Mvc5\Service\Config\Invokable\Invokable;
use Mvc5\Service\Config\Manager\Manager;
use Mvc5\Service\Config\Param\Param;
use Mvc5\Service\Config\Service\Service;
use Mvc5\Service\Config\ServiceConfig\ServiceConfig;
use Mvc5\Service\Config\ServiceManagerLink\ServiceManagerLink;
use Mvc5\Service\Resolver\Event;
use Mvc5\Service\Provider\Provider;
use Mvc5\Service\Provider\Resolver;

return [
    'Config'                => new ConfigLink,
    'Controller\Action'     => Controller\Action\Action::class,
    'Controller\Dispatch'   => Controller\Dispatch\Dispatch::class,
    'Controller\Dispatcher' => new Hydrator(
        Controller\Dispatch\Dispatcher::class,
        ['setControllerManager' => new Dependency('Controller\Manager')]
    ),
    'Controller\Error' => new Hydrator(
        Controller\Error\Controller::class,
        [
            'setModel' => new Service(
                Controller\Error\Model::class,
                ['error/404', ['message' => 'A 404 error occurred']]
            )
        ]
    ),
    'Controller\Exception' => Controller\Exception\Exception::class,
    'Controller\Exception\Controller' => new Hydrator(
        Controller\Exception\Controller::class,
        ['setModel' => new Dependency('Exception\Model')]
    ),
    'Controller\Manager' => new Manager(Controller\Manager\Manager::class),
    'Exception\Renderer' => new Hydrator(
        View\Exception\Renderer::class,
        ['setViewManager' => new Dependency('View\Manager')]
    ),
    'Exception\View' => new Hydrator(
        View\Exception\View::class,
        ['setModel' => new Dependency('Exception\Model')]
    ),
    'Exception\Model' => [View\Exception\Model::class, 'error/exception'],
    'Factory' => new Service(null, [new ServiceManagerLink]),
    'Layout'  => [View\Layout\Model::class, 'layout'],
    'Manager' => new Hydrator(null, [
        'aliases'       => new Param('alias'),
        'configuration' => new ConfigLink,
        'container'     => new ServiceConfig('Service\Container'),
        'events'        => new Param('events'),
        'services'      => new Param('services'),
    ]),
    'Mvc' => [Mvc\Mvc::class, new ServiceManagerLink],
    'Mvc\Controller' => new Hydrator(
        Mvc\Controller\Dispatcher::class,
        ['setControllerManager' => new Dependency('Controller\Manager')]
    ),
    'Mvc\Layout' => Mvc\Layout\Renderer::class,
    'Mvc\Response' => new Hydrator(
        Mvc\Response\Dispatcher::class,
        ['setResponseManager' => new Dependency('Response\Manager')]
    ),
    'Mvc\Route' => new Hydrator(
        Mvc\Route\Router::class,
        ['setRouteManager' => new Dependency('Route\Manager')]
    ),
    'Mvc\View' => new Hydrator(
        Mvc\View\Renderer::class,
        ['setViewManager' => new Dependency('View\Manager')]
    ),
    'Response\Dispatch'  => Response\Dispatch\Dispatch::class,
    'Response\Exception' => Response\Exception\Exception::class,
    'Response\Exception\Dispatch' => [Response\Exception\Dispatcher::class, 500],
    'Response\Exception\Renderer' => new Hydrator(
        Response\Exception\Renderer::class,
        ['setViewManager' => new Dependency('View\Manager')]
    ),
    'Response\Sender'  => Response\Send\Sender::class,
    'Response\Manager' => new Manager(Response\Manager\Manager::class),
    'Route' => [
        Route\Config::class,
        new Args([
            'hostname' => new Call('request.getHost'),
            'method'   => new Call('request.getMethod'),
            'path'     => new Call('request.getPathInfo'),
            'scheme'   => new Call('request.getScheme')
        ])
    ],
    'Route\Definition'  => Route\Definition\Route\Route::class,
    'Route\Dispatch'    => Route\Router\Dispatch::class,
    'Route\Error'       => new Invokable(new ServiceConfig('Route\Error\Route')),
    'Route\Error\Route' => new Hydrator(
        'Route',
        [['set', 'controller', 'Controller\Error'], ['set', 'name', 'error']]
    ),
    'Route\Exception'            => Route\Exception\Exception::class,
    'Route\Exception\Controller' => 'Controller\Exception\Controller',
    'Route\Exception\Create'     => [Route\Exception\Create::class, new Service('Route\Exception\Route')],
    'Route\Exception\Route'  => new Hydrator(
        Route\Exception\Config::class,
        [['set', 'controller', 'Route\Exception\Manager\Controller'], ['set', 'name', 'exception']]
    ),
    'Route\Exception\Manager\Controller' => new Hydrator(
        Route\Exception\Manager\Controller::class,
        ['setExceptionManager' => new Dependency('Route\Exception\Manager')]
    ),
    'Route\Exception\Manager' => new Manager(Route\Exception\Manager\Manager::class),
    'Route\Filter'    => Route\Filter\Filter::class,
    'Route\Generator' => [
        Route\Generator\Generator::class,
        new Param('routes'),
        new Dependency('Route\Definition\Url')
    ],
    'Route\Manager'        => new Manager(Route\Manager\Manager::class),
    'Route\Match'          => Route\Match\Match::class,
    'Route\Match\Hostname' => Route\Match\Hostname\Hostname::class,
    'Route\Match\Method'   => Route\Match\Method\Method::class,
    'Route\Match\Path'     => Route\Match\Path\Path::class,
    'Route\Match\Scheme'   => Route\Match\Scheme\Scheme::class,
    'Route\Match\Wildcard' => Route\Match\Wildcard\Wildcard::class,
    'Route\Plugin' => new Hydrator(
        Route\Plugin\Plugin::class,
        [
            'setRoute'          => new Dependency('Route'),
            'setRouteGenerator' => new Dependency('Route\Generator')
        ]
    ),
    'Route\Definition\Url' => Route\Definition\Url\Url::class,
    'Router' => new Service(
        Route\Router\Router::class,
        [new Param('routes')],
        ['setRouteManager' => new Dependency('Route\Manager')]
    ),
    'Service\Container'       => new Config\Config,
    'Service\DefaultResolver' => Resolver::class,
    'Service\Event\Create'    => [Event\Create::class, new Param('events')],
    'Service\Provider'        => Provider::class,
    'Service\Manager'         => new ServiceManagerLink,
    'View\Manager'            => new Manager(View\Manager\Manager::class),
    'View\Model'              => View\Model\Model::class,
    'View\Render'             => View\Render\Render::class,
    'View\Renderer' => new Hydrator(
        View\Renderer\Renderer::class,
        [
            'templates'      => new Param('templates'),
            'setViewManager' => new Dependency('View\Manager')
        ]
    )
];
