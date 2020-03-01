<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\Arg;

use function array_change_key_case;
use function implode;
use function is_string;
use function strtolower;

trait Headers
{
    /**
     * @var array
     */
    protected array $config = [];

    /**
     * @param array $headers
     */
    function __construct(array $headers = [])
    {
        $this->set($headers);
    }

    /**
     * @return array
     */
    function all() : array
    {
        return $this->config;
    }

    /**
     * @param array|string $name
     * @return array|string|null
     */
    function get($name)
    {
        if (is_string($name)) {
            return $this->config[strtolower($name)] ?? null;
        }

        $matched = [];

        foreach($name as $key) {
            $matched[$key] = $this->config[strtolower($key)] ?? null;
        }

        return $matched;
    }

    /**
     * @param array|string $name
     * @return bool
     */
    function has($name) : bool
    {
        if (is_string($name)) {
            return isset($this->config[strtolower($name)]);
        }

        foreach($name as $key) {
            if (!isset($this->config[strtolower($key)])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string|string[] $name
     * @return string|string[]
     */
    function header($name)
    {
        if (is_string($name)) {
            return implode(', ', (array) ($this->config[strtolower($name)] ?? ''));
        }

        $matched = [];

        foreach($name as $key) {
            $matched[$key] = implode(', ', (array) ($this->config[strtolower($key)] ?? ''));
        }

        return $matched;
    }

    /**
     * @param array|string $name
     */
    function remove($name) : void
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
