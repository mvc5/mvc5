<?php
/**
 *
 */

namespace Mvc5\Http\Headers;

use Mvc5\Arg;
use Mvc5\Immutable;
use Mvc5\Http\Headers;

class Config
    extends Immutable
    implements Headers
{
    /**
     * @param array $headers
     */
    function __construct(array $headers = [])
    {
        $headers = array_change_key_case($headers);
        parent::__construct(isset($headers[Arg::HOST]) ? [Arg::HOST => $headers[Arg::HOST]] + $headers : $headers);
    }

    /**
     * @param string $name
     * @return mixed
     */
    function get($name)
    {
        return parent::get(strtolower($name));
    }

    /**
     * @param string $name
     * @return bool
     */
    function has($name)
    {
        return parent::has(strtolower($name));
    }

    /**
     * @param array|string $name
     * @param mixed $value
     * @return mixed
     */
    protected function set($name, $value = null)
    {
        if (is_string($name)) {
            Arg::HOST !== $name ? $this->config[$name] = $value :
                $this->config = [Arg::HOST => $value] + $this->config;
            return $value;
        }

        isset($name[Arg::HOST]) &&
            $name = [Arg::HOST => $name[Arg::HOST]] + $name;

        $this->config = $name + $this->config;

        return $name;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return self|mixed
     */
    function with($name, $value = null)
    {
        return parent::with(is_array($name) ? array_change_key_case($name, CASE_LOWER) : strtolower($name), $value);
    }

    /**
     * @param string $name
     * @return self|mixed
     */
    function without($name)
    {
        return parent::without(is_array($name) ? array_change_key_case($name, CASE_LOWER) : strtolower($name));
    }
}
