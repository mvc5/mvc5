<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Route\Route;
use Mvc5\Route\Request;
use Mvc5\Signal;

class Controller
{
    /**
     *
     */
    use Signal;

    /**
     * @var callable|null
     */
    protected $loader;

    /**
     * @var array
     */
    protected $options = [
        Arg::PREFIX     => '',
        Arg::SEPARATORS => ['-' => '\\', '_' => '_'],
        Arg::SUFFIX     => '\Controller',
        Arg::SPLIT      => '\\',
        Arg::STRICT     => false
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
     * @param Request $request
     * @return null|string
     */
    protected function action(Request $request)
    {
        return $request->get(Arg::PARAMS)[Arg::ACTION] ?? null;
    }

    /**
     * @param Request $request
     * @return null|string
     */
    protected function controller(Request $request)
    {
        return $request->get(Arg::PARAMS)[Arg::CONTROLLER] ?? null;
    }

    /**
     * @param $name
     * @param array $options
     * @return string
     */
    protected function format($name, array $options)
    {
        return $options[Arg::STRICT] ? $this->replace($name, $options) : $this->uppercase($name, $options);
    }

    /**
     * @param $action
     * @param $controller
     * @param array $replacements
     * @return bool
     */
    protected function invalid($action, $controller, array $replacements)
    {
        return !$this->valid($controller, $replacements) || (!$this->valid($action, $replacements) && $action);
    }

    /**
     * @param $name
     * @return mixed
     */
    protected function load($name)
    {
        return $this->loader ? $this->signal($this->loader, [$name]) : class_exists($name);
    }

    /**
     * @param $name
     * @param $controller
     * @return mixed
     */
    protected function match($name, $controller)
    {
        return $controller ? (true === $controller ? $name : $controller) : null;
    }

    /**
     * @param $action
     * @param $controller
     * @param array $options
     * @return string
     */
    protected function name($action, $controller, array $options)
    {
        return $options[Arg::PREFIX] . $controller
            . ($action ? $options[Arg::SPLIT] . $action : '') . $options[Arg::SUFFIX];
    }

    /**
     * @param $route
     * @return mixed
     */
    protected function options($route)
    {
        return $route[Arg::OPTIONS] ? $route[Arg::OPTIONS] + $this->options : $this->options;
    }

    /**
     * @param string $name
     * @param array $options
     * @return string
     */
    protected function replace($name, array $options)
    {
        return str_replace(array_keys($options[Arg::SEPARATORS]), array_values($options[Arg::SEPARATORS]), $name);
    }

    /**
     * @param array $options
     * @return array
     */
    protected function replacements(array $options)
    {
        return array_filter(array_values($options[Arg::SEPARATORS]));
    }

    /**
     * @param string $name
     * @param array $options
     * @return string
     */
    protected function uppercase($name, array $options)
    {
        foreach($options[Arg::SEPARATORS] as $separator => $replacement) {
            $name = str_replace(' ', $replacement, ucwords(str_replace($separator, ' ', $name)));
        }

        return $name;
    }

    /**
     * @param string $name
     * @param array $replacements
     * @return bool
     */
    protected function valid($name, array $replacements)
    {
        return $name && str_replace($replacements, '', $name);
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return Request
     */
    function __invoke(Request $request, Route $route)
    {
        if ($request->controller()) {
            return $request;
        }

        $options    = $this->options($route);
        $action     = $this->format($this->action($request), $options);
        $controller = $this->format($this->controller($request), $options);
        $name       = $this->name($action, $controller, $options);

        if ($this->invalid($action, $controller, $this->replacements($options))) {
            return null;
        }

        $controller = $this->match($name, $this->load($name));

        if (!$controller) {
            return null;
        }

        $request[Arg::CONTROLLER] = $controller;

        return $request;
    }
}
