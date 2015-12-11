<?php
/**
 *
 */

use Mvc5\Plugin\Config;
use Mvc5\Plugin\Dependency;
use Mvc5\Plugin\Invoke;
use Mvc5\Plugin\Invokable;
use Mvc5\Plugin\Model;
use Mvc5\Plugin\Mvc;
use Mvc5\Plugin\Param;
use Mvc5\Plugin\Plugin;
use Mvc5\Plugin\Service;

return [
    'config'                     => new Config,
    'container'                  => new Mvc5\Config,
    'controller\dispatch'        => [Mvc5\Event::class, 'controller\dispatch'],
    'controller\action'          => new Service(Mvc5\Controller\Action::class),
    'controller\exception'       => new Mvc('controller\exception'),
    'event\model'                => Mvc5\Event::class,
    'exception\controller'       => [Mvc5\Controller\Exception::class, new Plugin('exception\model')],
    'exception\model'            => [Mvc5\Layout::class, 'error/exception'],
    'exception\route'            => [Mvc5\Route\Exception\Create::class, new Plugin('route\exception\route')],
    'exception\status'           => [Mvc5\Response\Status::class, 500],
    'exception\view'             => new Invoke('view\render'),
    'factory'                    => new Service(null),
    'layout'                     => [Mvc5\Layout::class, 'layout'],
    'mvc'                        => new Mvc('mvc'),
    'mvc\controller'             => new Service(Mvc5\Mvc\Controller::class),
    'mvc\layout'                 => Mvc5\Mvc\Layout::class,
    'mvc\response'               => new Service(Mvc5\Mvc\Response::class),
    'mvc\route'                  => new Service(Mvc5\Mvc\Route::class),
    'mvc\view'                   => new Service(Mvc5\Mvc\View::class),
    'resolver\exception'         => Mvc5\Resolver\Exception::class,
    'response\dispatch'          => new Mvc('response\dispatch'),
    'response\exception'         => new Mvc('response\exception'),
    'response\send'              => Mvc5\Response\Send::class,
    'route\generator'            => new Dependency('route\generator', Mvc5\Route\Generator::class),
    'route\dispatch'             => Mvc5\Route\Dispatch::class,
    'route\error'                => [Mvc5\Route\Error\Create::class, new Plugin('route\error\route')],
    'route\error\controller'     => new Invokable(new Plugin('route\error\model')),
    'route\error\dispatch'       => [Mvc5\Event::class, 'route\error\dispatch'],
    'route\error\model'          => new Model('error/404', ['message' => 'A 404 error occurred']),
    'route\error\route'          => [Mvc5\Route\Error\Route::class, ['controller' => 'route\error\dispatch']],
    'route\error\status'         => [Mvc5\Response\Status::class, 404],
    'route\exception'            => new Mvc('route\exception'),
    'route\exception\route'      => [Mvc5\Route\Exception\Route::class, ['controller' => 'route\exception\controller']],
    'route\exception\controller' => [Mvc5\Route\Exception\Controller::class, new Plugin('exception\model')],
    'route\filter'               => Mvc5\Route\Filter::class,
    'route\match'                => Mvc5\Route\Match::class,
    'route\match\hostname'       => Mvc5\Route\Match\Hostname::class,
    'route\match\method'         => Mvc5\Route\Match\Method::class,
    'route\match\path'           => Mvc5\Route\Match\Path::class,
    'route\match\scheme'         => Mvc5\Route\Match\Scheme::class,
    'route\match\wildcard'       => Mvc5\Route\Match\Wildcard::class,
    'router'                     => new Service(Mvc5\Route\Router::class, [new Param('routes')]),
    'service\locator'            => new Service(Mvc5\Resolver\Service::class, [new Param('events')]),
    'service\resolver'           => new Dependency('service\resolver', Mvc5\Resolver\Dispatch::class),
    'url'                        => new Dependency('url\plugin'),
    'url\generator'              => [Mvc5\Url\Generator::class, new Param('routes')],
    'url\plugin'                 => [Mvc5\Url\Plugin::class, new Dependency('route'), new Plugin('url\generator')],
    'view\exception'             => new Mvc('view\exception'),
    'view\render'                => Mvc5\View\Render::class,
    'view\renderer'              => new Service(Mvc5\View\Template\Renderer::class, [new Param('templates')])
];
