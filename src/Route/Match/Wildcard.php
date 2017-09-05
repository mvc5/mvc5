<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Route\Route;

class Wildcard
{
    /**
     * @var array
     */
    protected $options = [
        Arg::WILDCARD => 'wildcard'
    ];

    /**
     * @param array $options
     */
    function __construct(array $options = [])
    {
        $options && $this->options = $options + $this->options;
    }

    /**
     * @param array $params
     * @param array $options
     * @param array $parts
     * @return array
     */
    protected function match(array $params, array $options, array $parts) : array
    {
        return ($n = count($parts)) % 2 ? $params : $this->set($this->remove($params, $options), $parts, $n);
    }

    /**
     * @param Route $route
     * @return array
     */
    protected function options(Route $route) : array
    {
        return $route[Arg::OPTIONS] ? $route[Arg::OPTIONS] + $this->options : $this->options;
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function params(Request $request) : array
    {
        return $request->get(Arg::PARAMS) ?? [];
    }

    /**
     * @param array $params
     * @param array $options
     * @return array
     */
    protected function parts(array $params, array $options) : array
    {
        return isset($params[$options[Arg::WILDCARD]]) ? explode(Arg::SEPARATOR, $params[$options[Arg::WILDCARD]]) : [];
    }

    /**
     * @param array $params
     * @param array $options
     * @return array
     */
    protected function remove(array $params, array $options) : array
    {
        unset($params[$options[Arg::WILDCARD]]);

        return $params;
    }

    /**
     * @param Request $request
     * @param array $matched
     * @return Request
     */
    protected function request(Request $request, array $matched = []) : Request
    {
        return $matched ? $request->with(Arg::PARAMS, $matched) : $request;
    }

    /**
     * @param array $params
     * @param array $parts
     * @param int $n
     * @return array
     */
    protected function set(array $params, array $parts, int $n) : array
    {
        for($i = 0; $i < $n; $i += 2) {
            if (isset($params[$parts[$i]])) {
                continue;
            }

            $params[$parts[$i]] = $parts[$i + 1];
        }

        return $params;
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request|mixed
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        if (!$route->wildcard()) {
            return $next($route, $request);
        }

        $params  = $this->params($request);
        $options = $this->options($route);

        $request = $this->request($request, $this->match($params, $options, $this->parts($params, $options)));

        return $next($route, $request);
    }
}
