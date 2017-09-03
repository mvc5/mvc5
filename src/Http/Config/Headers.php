<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\Arg;

trait Headers
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @param array $headers
     */
    function __construct(array $headers = [])
    {
        $this->set($headers);
    }

    /**
     * @param string $name
     * @return mixed
     */
    function get($name)
    {
        return $this->config[strtolower($name)] ?? null;
    }

    /**
     * @param string $name
     * @return bool
     */
    function has($name)
    {
        return isset($this->config[strtolower($name)]);
    }

    /**
     * @param array|string $name
     */
    function remove($name)
    {
        foreach(array_change_key_case((array) (is_string($name) ? strtolower($name) : $name)) as $key) {
            unset($this->config[$key]);
        }
    }

    /**
     * @param array|string $name
     * @param mixed $value
     * @return mixed
     */
    function set($name, $value = null)
    {
        $headers = array_change_key_case(is_string($name) ? [$name => $value] : (array) $name);

        $this->config = !isset($headers[Arg::HOST]) ? $headers + $this->config :
            [Arg::HOST => $headers[Arg::HOST]] + $headers + $this->config;

        return is_string($name) ? $value : $name;
    }
}
