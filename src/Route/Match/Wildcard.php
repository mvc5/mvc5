<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Route\Route;
use Mvc5\Route\Request;

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
    protected function match($params, $options, $parts)
    {
        return ($n = count($parts)) % 2 ? $params : $this->set($this->remove($params, $options), $parts, $n);
    }

    /**
     * @param Route $route
     * @return array
     */
    protected function options(Route $route)
    {
        return $route[Arg::OPTIONS] ? $route[Arg::OPTIONS] + $this->options : $this->options;
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function params(Request $request)
    {
        return $request->get(Arg::PARAMS) ?: [];
    }

    /**
     * @param $params
     * @param $options
     * @return array
     */
    protected function parts($params, $options)
    {
        return isset($params[$options[Arg::WILDCARD]]) ? explode(Arg::SEPARATOR, $params[$options[Arg::WILDCARD]]) : [];
    }

    /**
     * @param $params
     * @param $options
     * @return mixed
     */
    protected function remove($params, $options)
    {
        unset($params[$options[Arg::WILDCARD]]);

        return $params;
    }

    /**
     * @param array $params
     * @param array $parts
     * @param int $n
     * @return array
     */
    protected function set(array $params, array $parts, $n)
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
     * @param Request $request
     * @param Route $route
     * @return Request
     */
    function __invoke(Request $request, Route $route)
    {
        if (!$route->wildcard()) {
            return $request;
        }

        $params  = $this->params($request);
        $options = $this->options($route);

        $request[Arg::PARAMS] = $this->match($params, $options, $this->parts($params, $options));

        return $request;
    }
}
