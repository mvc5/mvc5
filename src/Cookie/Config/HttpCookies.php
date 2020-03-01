<?php
/**
 *
 */

namespace Mvc5\Cookie\Config;

use Mvc5\Arg;
use Mvc5\Cookie\Cookies;

use function is_array;
use function is_string;
use function key;

const EXPIRE_TIME = 946706400;

trait HttpCookies
{
    /**
     * @var array
     */
    protected array $config = [];

    /**
     * @param array $cookies
     */
    function __construct(array $cookies = [])
    {
        $this->config = $cookies;
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
     * @param array $options
     */
    function remove($name, array $options = []) : void
    {
        $this->set(expire(cookie(is_string($name) ? [Arg::NAME => $name] + $options : $name)));
    }

    /**
     * @param array|string $name
     * @param string|null $value
     * @param array $options
     * @return mixed
     */
    function set($name, $value = null, array $options = [])
    {
        if (is_array($name)) {
            $cookie = cookie($name);

            $this->config[$cookie[Arg::NAME]] = $cookie;

            return $name;
        }

        $this->config[$name] = [Arg::NAME => (string) $name, Arg::VALUE => (string) $value] + $options;

        return $value;
    }

    /**
     * @param array|string $name
     * @param string|null $value
     * @param array $options
     * @return self|mixed
     */
    function with($name, $value = null, array $options = []) : Cookies
    {
        $new = clone $this;
        $new->set($name, $value, $options);
        return $new;
    }

    /**
     * @param array|string $name
     * @param array $options
     * @return self|mixed
     */
    function without($name, array $options = []) : Cookies
    {
        $new = clone $this;
        $new->remove($name, $options);
        return $new;
    }
}

/**
 * @param array $cookie
 * @return array
 */
function cookie(array $cookie) : array
{
    return is_string(key($cookie)) ? $cookie : [
        Arg::NAME => $cookie[0],
        Arg::VALUE => $cookie[1] ?? null,
        Arg::EXPIRES => $cookie[2] ?? null,
        Arg::PATH => $cookie[3] ?? null,
        Arg::DOMAIN => $cookie[4] ?? null,
        Arg::SECURE => $cookie[5] ?? null,
        Arg::HTTP_ONLY => $cookie[6] ?? null,
        Arg::SAMESITE => $cookie[7] ?? null
    ];
}

/**
 * @param array $cookie
 * @return array
 */
function expire(array $cookie) : array
{
    $cookie[Arg::VALUE] = '';

    isset($cookie[Arg::OPTIONS]) ? $cookie[Arg::OPTIONS][Arg::EXPIRES] = EXPIRE_TIME : $cookie[Arg::EXPIRES] = EXPIRE_TIME;

    return $cookie;
}
