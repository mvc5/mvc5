<?php
/**
 *
 */

namespace Mvc5\Plugins;

use const Mvc5\URL;

trait Url
{
    /**
     * @param array|string|\Mvc5\Http\Uri|null $route
     * @param array|string|null $query
     * @param string|null $fragment
     * @param array $options
     * @return string|null
     */
    protected function url($route = null, $query = null, string $fragment = null, array $options = []) : ?string
    {
        return $this->call(URL, [$route, $query, $fragment, $options]);
    }
}
