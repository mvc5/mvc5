<?php
/**
 *
 */

namespace Mvc5\Plugins;

use Mvc5\Arg;

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
     * @param null $name
     * @param array $params
     * @param array $options
     * @return string
     */
    protected function url($name = null, array $params = [], array $options = [])
    {
        return $this->call(Arg::URL, [$name, $params, $options]);
    }
}
