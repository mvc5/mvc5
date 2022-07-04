<?php
/**
 *
 */

namespace Mvc5\Cookie\Config;

use Mvc5\Cookie\Cookies;

use function is_array;
use function is_string;
use function key;

use const Mvc5\{ COOKIE_EXPIRE_TIME, DOMAIN, EXPIRES, HTTP_ONLY, NAME, OPTIONS, PATH, SAMESITE, SECURE, VALUE };

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
        $this->set(expire(cookie(is_string($name) ? [NAME => $name] + $options : $name)));
    }

    /**
     * @param array|string $name
     * @param string|null $value
     * @param array $options
     * @return mixed
     */
    function set($name, $value = null, array $options = []) : mixed
    {
        if (is_array($name)) {
            $cookie = cookie($name);

            $this->config[$cookie[NAME]] = $cookie;

            return $name;
        }

        $this->config[$name] = [NAME => (string) $name, VALUE => (string) $value] + $options;

        return $value;
    }

    /**
     * @param array|string $name
     * @param string|null $value
     * @param array $options
     * @return Cookies|mixed
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
     * @return Cookies|mixed
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
        NAME => $cookie[0],
        VALUE => $cookie[1] ?? null,
        EXPIRES => $cookie[2] ?? null,
        PATH => $cookie[3] ?? null,
        DOMAIN => $cookie[4] ?? null,
        SECURE => $cookie[5] ?? null,
        HTTP_ONLY => $cookie[6] ?? null,
        SAMESITE => $cookie[7] ?? null
    ];
}

/**
 * @param array $cookie
 * @return array
 */
function expire(array $cookie) : array
{
    $cookie[VALUE] = '';

    isset($cookie[OPTIONS]) ? $cookie[OPTIONS][EXPIRES] = COOKIE_EXPIRE_TIME : $cookie[EXPIRES] = COOKIE_EXPIRE_TIME;

    return $cookie;
}
