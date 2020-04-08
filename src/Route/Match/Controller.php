<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Http\Error\NotFound;
use Mvc5\Http\Request;
use Mvc5\Route\Route;

use function array_keys;
use function array_values;
use function class_exists;
use function str_replace;
use function ucwords;

use const Mvc5\{ ACTION, CONTROLLER, MIDDLEWARE, PARAMS, PREFIX, SEPARATORS, SPLIT, STRICT, SUFFIX };

final class Controller
{
    /**
     * @var callable|null
     */
    protected $loader;

    /**
     * @var array
     */
    protected array $options = [
        ACTION     => 'action',
        CONTROLLER => 'controller',
        PREFIX     => '',
        SEPARATORS => ['/' => '\\'],
        SPLIT      => '\\',
        STRICT     => false,
        SUFFIX     => '\Controller'
    ];

    /**
     * @param callable|null $loader
     * @param array $options
     */
    function __construct(callable $loader = null, array $options = [])
    {
        $loader && $this->loader = $loader;
        $options && $this->options = $options + $this->options;
    }

    /**
     * @param array $params
     * @param array $options
     * @return string
     */
    protected function action(array $params, array $options) : string
    {
        return $params[$options[ACTION]] ?? '';
    }

    /**
     * @param array $params
     * @param array $options
     * @return string
     */
    protected function controller(array $params, array $options) : string
    {
        return $params[$options[CONTROLLER]] ?? '';
    }

    /**
     * @param string $name
     * @param array $options
     * @return string
     */
    protected function format(string $name, array $options) : string
    {
        return $options[STRICT] ? $this->replace($name, $options) : $this->uppercase($name, $options);
    }

    /**
     * @param string $action
     * @param string $controller
     * @param array $replacement
     * @return bool
     */
    protected function invalid(string $action, string $controller, array $replacement) : bool
    {
        return !$this->valid($controller, $replacement) || (!$this->valid($action, $replacement) && $action);
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function load(string $name)
    {
        return $this->loader ? ($this->loader)($name) : class_exists($name);
    }

    /**
     * @param string $name
     * @param bool|mixed $controller
     * @return string|mixed
     */
    protected function match(string $name, $controller)
    {
        return $controller ? (true === $controller ? $name : $controller) : null;
    }

    /**
     * @param string|null $action
     * @param string|null $controller
     * @param array $options
     * @return string
     */
    protected function name(string $action = null, string $controller = null, array $options = []) : string
    {
        return $options[PREFIX] . $controller
            . ($action ? $options[SPLIT] . $action : '') . $options[SUFFIX];
    }

    /**
     * @param Route $route
     * @return array
     */
    protected function options(Route $route) : array
    {
        return $route->options() + $this->options;
    }

    /**
     * @param string $name
     * @param array $options
     * @return string
     */
    protected function replace(string $name, array $options) : string
    {
        return str_replace($this->separator($options), $this->replacement($options), $name);
    }

    /**
     * @param array $options
     * @return array
     */
    protected function replacement(array $options) : array
    {
        return array_values($options[SEPARATORS]);
    }

    /**
     * @param array $options
     * @return array
     */
    protected function separator(array $options) : array
    {
        return array_keys($options[SEPARATORS]);
    }

    /**
     * @param string $name
     * @param array $options
     * @return string
     */
    protected function uppercase(string $name, array $options) : string
    {
        foreach($options[SEPARATORS] as $separator => $replacement) {
            $name = str_replace(' ', $replacement, ucwords(str_replace($separator, ' ', $name)));
        }

        return $name;
    }

    /**
     * @param string $name
     * @param array $replacement
     * @return bool
     */
    protected function valid(string $name, array $replacement) : bool
    {
        return $name && str_replace($replacement, '', $name);
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return NotFound|Request|mixed
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        if ($request[CONTROLLER]) {
            return $next($route, $request);
        }

        $options    = $this->options($route);
        $params     = $request[PARAMS] ?? [];
        $action     = $this->action($params, $options);
        $controller = $this->controller($params, $options);

        if (!$controller && !empty($route[MIDDLEWARE])) {
            return $next($route, $request);
        }

        $action     = $this->format($action, $options);
        $controller = $this->format($controller, $options);
        $name       = $this->name($action, $controller, $options);

        if ($this->invalid($action, $controller, $this->replacement($options))) {
            return null;
        }

        $controller = $this->match($name, $this->load($name));

        if (!$controller) {
            return new NotFound;
        }

        return $next($route, $request->with(CONTROLLER, $controller));
    }
}
