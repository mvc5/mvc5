<?php
/**
 *
 */

use Mvc5\Plugin\Config;
use Mvc5\Plugin\Dependency;
use Mvc5\Plugin\Invokable;
use Mvc5\Plugin\Link;
use Mvc5\Plugin\Model;
use Mvc5\Plugin\Param;
use Mvc5\Plugin\Plugin;
use Mvc5\Plugin\Response;
use Mvc5\Plugin\Service;

return [
    'config'                     => new Config,
    'container'                  => new Mvc5\Config,
    'controller\exception'       => new Response('controller\exception'),
    'error\controller'           => new Invokable(new Plugin('error\model')),
    'error\model'                => new Model('error/404', ['message' => 'A 404 error occurred']),
    'error\response'             => 'response\controller',
    'error\route'                => [Mvc5\Route\Error\Create::class, 'error', 'error\controller'],
    'error\status'               => ['response\status', 404],
    'error\view'                 => 'view\render',
    'event\model'                => Mvc5\Event::class,
    'exception\controller'       => [Mvc5\Controller\Exception::class, new Plugin('exception\model')],
    'exception\model'            => ['layout', 'error/exception'],
    'exception\response'         => 'response\controller',
    'exception\route'            => [Mvc5\Route\Exception\Create::class, 'exception', 'exception\route\controller'],
    'exception\route\controller' => [Mvc5\Route\Exception\Controller::class, new Plugin('exception\model')],
    'exception\status'           => ['response\status', 500],
    'exception\view'             => 'view\render',
    'factory'                    => new Service(null),
    'layout'                     => [Mvc5\Layout::class, 'layout'],
    'manager'                    => new Plugin(null),
    'mvc'                        => new Plugin(Mvc5\Mvc::class, ['mvc', new Link], [new Dependency('route')]),
    'mvc\controller'             => new Service(Mvc5\Mvc\Controller::class),
    'mvc\layout'                 => Mvc5\Mvc\Layout::class,
    'mvc\response'               => Mvc5\Mvc\Response::class,
    'mvc\route'                  => new Service(Mvc5\Mvc\Route::class),
    'mvc\view'                   => new Service(Mvc5\Mvc\View::class),
    'resolver\exception'         => Mvc5\Resolver\Exception::class,
    'resolver\dispatch'          => Mvc5\Resolver\Dispatch::class,
    'response\controller'        => Mvc5\Response\Controller::class,
    'response\dispatch'          => [Mvc5\Response\Dispatch::class, 'response' => new Dependency('response')],
    'response\exception'         => new Response('response\exception', ['response' => new Plugin('response')]),
    'response\send'              => Mvc5\Response\Send::class,
    'response\status'            => Mvc5\Response\Status::class,
    'route\generator'            => new Dependency('route\definition\generator'),
    'route\definition\generator' => Mvc5\Route\Generator::class,
    'route\dispatch'             => Mvc5\Route\Dispatch::class,
    'route\error'                => new Response('route\error'),
    'route\exception'            => new Response('route\exception'),
    'route\filter'               => Mvc5\Route\Filter::class,
    'route\match'                => Mvc5\Route\Match::class,
    'route\match\hostname'       => Mvc5\Route\Match\Hostname::class,
    'route\match\method'         => Mvc5\Route\Match\Method::class,
    'route\match\path'           => Mvc5\Route\Match\Path::class,
    'route\match\scheme'         => Mvc5\Route\Match\Scheme::class,
    'route\match\wildcard'       => Mvc5\Route\Match\Wildcard::class,
    'router'                     => new Service(Mvc5\Route\Router::class, [new Param('routes')]),
    'service\resolver'           => new Dependency('resolver\dispatch'),
    'url'                        => new Dependency('url\plugin'),
    'url\generator'              => [Mvc5\Url\Generator::class, new Param('routes')],
    'url\plugin'                 => [Mvc5\Url\Plugin::class, new Dependency('route'), new Plugin('url\generator')],
    'view\exception'             => new Response('view\exception'),
    'view\render'                => Mvc5\View\Render::class,
    'view\renderer'              => new Service(Mvc5\View\Template\Renderer::class, [new Param('templates')]),
    'web'                        => new Response('web')
];
