<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;
use Mvc5\Http\Uri;

trait Url
{
    /**
     * @param array|callable|object|string $name
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     */
    protected abstract function call($name, array $args = [], callable $callback = null);

    /**
     * @param array|null|string|Uri $route
     * @param array|string $query
     * @param string $fragment
     * @param array $options
     * @return string
     */
    protected function url($route = null, $query = '', $fragment = '', array $options = [])
    {
        return $this->call(Arg::URL, [$route, $query, $fragment, $options]);
    }
}
