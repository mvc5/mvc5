<?php
/**
 *
 */

use Mvc5\Plugin\Config;
use Mvc5\Plugin\Dependency;
use Mvc5\Plugin\Hydrator;
use Mvc5\Plugin\Link;
use Mvc5\Plugin\Param;
use Mvc5\Plugin\Plug;
use Mvc5\Plugin\Plugin;
use Mvc5\Plugin\Response;
use Mvc5\Plugin\Service;

return [
    'config'                     => new Config,
    'controller\action'          => new Service(Mvc5\Controller\Action::class),
    'error\controller'           => new Hydrator(Mvc5\Request\Error\Controller::class, ['setModel' => new Plugin('error\model')]),
    'error\model'                => [Mvc5\Request\Error\Model::class, 'error/error'],
    'error\status'               => Mvc5\Request\Error\Status::class,
    'event\model'                => Mvc5\Event::class,
    'exception\controller'       => [Mvc5\Request\Exception\Controller::class, new Plugin('layout', ['error/exception'])],
    'exception\error'            => [Mvc5\Request\Exception\Error::class, 'exception', 'exception\route\controller'],
    'exception\request'          => ['response\status', 500],
    'factory'                    => new Service(null),
    'layout'                     => [Mvc5\Layout::class, 'layout'],
    'manager'                    => new Plugin(null),
    'middleware'                 => new Service(Mvc5\Middleware::class, [new Param('middleware.web')]),
    'request'                    => Mvc5\Request\Config::class,
    'resolver\exception'         => Mvc5\Resolver\Exception::class,
    'response'                   => Mvc5\Response\Config::class,
    'response\dispatch'          => [Mvc5\Response\Dispatch::class, 'response' => new Plugin('response')],
    'response\exception'         => new Response('response\exception'),
    'response\model'             => Mvc5\Response\Model::class,
    'response\send'              => Mvc5\Response\Send::class,
    'response\status'            => Mvc5\Response\Status::class,
    'response\version'           => Mvc5\Response\Version::class,
    'route\dispatch'             => Mvc5\Route\Dispatch::class,
    'route\generator'            => Mvc5\Route\Generator::class,
    'route\error'                => [Mvc5\Route\Error::class, 'error', 'error\controller'],
    'route\match'                => Mvc5\Route\Match::class,
    'route\match\action'         => Mvc5\Route\Match\Action::class,
    'route\match\host'           => Mvc5\Route\Match\Host::class,
    'route\match\path'           => Mvc5\Route\Match\Path::class,
    'route\match\method'         => Mvc5\Route\Match\Method::class,
    'route\match\scheme'         => Mvc5\Route\Match\Scheme::class,
    'route\match\wildcard'       => Mvc5\Route\Match\Wildcard::class,
    'route\router'               => new Service(Mvc5\Route\Router::class, [new Param('routes')]),
    'route\service'              => [Mvc5\Route\Service::class, new Link],
    'service\resolver'           => Mvc5\Resolver\Dispatch::class,
    'url'                        => new Dependency('url\plugin'),
    'url\generator'              => [Mvc5\Url\Generator::class, new Param('routes')],
    'url\plugin'                 => [Mvc5\Url\Plugin::class, new Dependency('request'), new Plugin('url\generator')],
    'view\layout'                => Mvc5\View\Layout::class,
    'view\render'                => new Service(Mvc5\View\Render::class, [new Param('templates')]),
    'web'                        => new Plugin(Mvc5\Mvc::class, ['web', new Link], [new Dependency('response')]),
    'web\route'                  => new Service(Mvc5\Web\Route::class),
    'web\controller'             => new Service(Mvc5\Web\Controller::class),
    'web\layout'                 => new Service(Mvc5\Web\Layout::class),
    'web\send'                   => new Service(Mvc5\Web\Send::class),
    'web\status'                 => new Service(Mvc5\Web\Status::class),
    'web\version'                => new Service(Mvc5\Web\Version::class),
    'web\view'                   => new Service(Mvc5\Web\View::class),
];
