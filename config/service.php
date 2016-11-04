<?php
/**
 *
 */

use Mvc5\Plugin\Config;
use Mvc5\Plugin\Hydrator;
use Mvc5\Plugin\Link;
use Mvc5\Plugin\Param;
use Mvc5\Plugin\Plugin;
use Mvc5\Plugin\Response;
use Mvc5\Plugin\Service;
use Mvc5\Plugin\Session;
use Mvc5\Plugin\Shared;

return [
    'config'               => new Config,
    'cookie'               => new Shared('cookie', [Mvc5\Cookie\Config::class, new Plugin('cookie\sender'), $_COOKIE]),
    'cookie\container'     => [Mvc5\Cookie\Container::class, new Param('cookie')],
    'cookie\sender'        => [Mvc5\Cookie\Sender::class, new Param('cookie')],
    'controller\action'    => [Mvc5\Controller\Action::class, new Link],
    'error\controller'     => [Mvc5\Request\Error\Controller::class, new Plugin('error\model')],
    'error\model'          => [Mvc5\Request\Error\Model::class, 'error'],
    'event\model'          => Mvc5\Event::class,
    'exception\controller' => [Mvc5\Request\Exception\Controller::class, new Plugin('exception\layout')],
    'exception\error'      => [Mvc5\Request\Exception::class, 'exception', 'exception\controller'],
    'exception\layout'     => [Mvc5\Layout::class, 'exception'],
    'exception\log'        => ['log', 'throw_exception' => false],
    'exception\response'   => new Response('exception\response'),
    'factory'              => new Service(null),
    'layout'               => [Mvc5\Layout::class, 'layout'],
    'log'                  => Mvc5\Log\Logger::class,
    'log\error'            => Mvc5\Log\Error::class,
    'log\exception'        => Mvc5\Log\Exception::class,
    'manager'              => new Plugin(null),
    'Mvc5\Service\Service' => new Link,
    'render'               => new Shared('view\renderer'),
    'request'              => Mvc5\Request\Config::class,
    'request\error'        => [Mvc5\Request\Error::class, 'error', 'error\controller'],
    'request\service'      => [Mvc5\Request\Service::class, new Link],
    'resolver\exception'   => Mvc5\Resolver\Exception::class,
    'response'             => Mvc5\Response\Config::class,
    'response\dispatch'    => Mvc5\Response\Dispatch::class,
    'response\json'        => Mvc5\Response\Json::class,
    'response\redirect'    => Mvc5\Response\Redirect::class,
    'response\send'        => Mvc5\Response\Send::class,
    'response\status'      => Mvc5\Response\Status::class,
    'response\version'     => Mvc5\Response\Version::class,
    'route\dispatch'       => new Service(Mvc5\Route\Dispatch::class, [new Param('routes')]),
    'route\generator'      => Mvc5\Route\Generator::class,
    'route\match'          => Mvc5\Route\Match::class,
    'route\match\action'   => Mvc5\Route\Match\Action::class,
    'route\match\host'     => Mvc5\Route\Match\Host::class,
    'route\match\merge'    => Mvc5\Route\Match\Merge::class,
    'route\match\method'   => Mvc5\Route\Match\Method::class,
    'route\match\path'     => Mvc5\Route\Match\Path::class,
    'route\match\scheme'   => Mvc5\Route\Match\Scheme::class,
    'route\match\controller' => [Mvc5\Route\Match\Controller::class, new Link],
    'route\match\wildcard' => Mvc5\Route\Match\Wildcard::class,
    'service\resolver'     => Mvc5\Resolver\Dispatch::class,
    'session'              => new Shared('session', 'session\global'),
    'session\container'    => new Plugin(Mvc5\Session\Container::class, ['session' => new Plugin('session')], ['start' => []]),
    'session\global'       => new Hydrator(Mvc5\Session\Config::class, ['start' => new Param('session')]),
    'session\messages'     => new Shared('session\messages', new Session('session\messages', Mvc5\Session\Messages::class)),
    'template\render'      => new Service(Mvc5\View\Render::class, [new Param('templates'), new Param('view')]),
    'url'                  => new Shared('url\plugin'),
    'url\generator'        => [Mvc5\Url\Generator::class, new Param('routes')],
    'url\plugin'           => [Mvc5\Url\Plugin::class, new Shared('request'), new Plugin('url\generator')],
    'view\layout'          => Mvc5\View\Layout::class,
    'view\model'           => Mvc5\Model::class,
    'view\render'          => new Shared('template\render'),
    'view\renderer'        => [Mvc5\View\Renderer::class, new Shared('template\render')],
    'web'                  => new Response('web'),
    'web\controller'       => [Mvc5\Web\Controller::class, new Link],
    'web\error'            => [Mvc5\Web\Error::class, 'error', 'error\controller'],
    'web\layout'           => [Mvc5\Web\Layout::class, new Plugin('layout')],
    'web\middleware'       => new Service(Mvc5\Middleware::class, ['stack' => new Param('middleware.web')]),
    'web\render'           => [Mvc5\Web\Render::class, new Shared('template\render')],
    'web\route'            => new Service(Mvc5\Web\Route::class, [new Param('routes')]),
    'web\send'             => Mvc5\Web\Send::class,
    'web\service'          => [Mvc5\Web\Service::class, new Link],
    'web\status'           => Mvc5\Web\Status::class,
    'web\version'          => Mvc5\Web\Version::class,
];
