<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;

trait Url
{
    /**
     * @param array|null|string|\Mvc5\Http\Uri $route
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
