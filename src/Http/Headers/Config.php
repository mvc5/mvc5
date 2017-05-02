<?php
/**
 *
 */

namespace Mvc5\Http\Headers;

use Mvc5\Arg;
use Mvc5\Model;
use Mvc5\Http\Headers;

class Config
    extends Model
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
     * @return self|mixed
     */
    function with($name, $value = null)
    {
        if (is_string($name)) {
            $name = strtolower($name);
            $new = clone $this;

            Arg::HOST !== $name ? $new->config[$name] = $value
                : $new->config = [Arg::HOST => $value] + $new->config;

            return $new;
        }

        $name = array_change_key_case($name, CASE_LOWER);

        $new = clone $this;

        if (isset($name[Arg::HOST])) {
            $new->config = [Arg::HOST => $name[Arg::HOST]] + $name + $this->config;
            return $new;
        }

        foreach($name as $key => $value) {
            $new->config[$key] = $value;
        }

        return $new;
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
