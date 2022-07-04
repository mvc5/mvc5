<?php
/**
 *
 */

namespace Mvc5\Cookie\Config;

use Mvc5\Cookie\Cookies;

use function is_array;
use function is_string;
use function setcookie;
use function setrawcookie;
use function strtotime;

use const Mvc5\{ DOMAIN, EXPIRES, HTTP_ONLY, NAME, OPTIONS, PATH, RAW, SAMESITE, SECURE, VALUE };

trait PHPCookies
{
    /**
     *
     */
    use HttpCookies;

    /**
     * @var array
     */
    protected array $defaults = [];

    /**
     * @param array|null $cookies
     * @param array $defaults
     */
    function __construct(array $cookies = null, array $defaults = [])
    {
        $this->config = $cookies ?? $_COOKIE;
        $this->defaults = $defaults;
    }

    /**
     * @param array|string $cookie
     * @param array $options
     * @return bool
     */
    static function delete($cookie, array $options = []) : bool
    {
        return static::send(expire(cookie(is_string($cookie) ? [NAME => $cookie] + $options : $cookie)));
    }

    /**
     * @param array $cookie
     * @param array $defaults
     * @return bool
     */
    static function send(array $cookie, array $defaults = []) : bool
    {
        return send(cookie($cookie), $defaults);
    }

    /**
     * @param array|string $name
     * @param string $value
     * @param array $options
     * @return mixed
     */
    function set($name, $value = '', array $options = []) : mixed
    {
        if (is_array($name)) {
            $this->send($name, $this->defaults);
            return $name;
        }

        $this->send([NAME => (string) $name, VALUE => (string) $value] + $options, $this->defaults);

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
        $this->set($name, $value, $options);
        return $this;
    }

    /**
     * @param array|string $name
     * @param array $options
     * @return Cookies|mixed
     */
    function without($name, array $options = []) : Cookies
    {
        $this->remove($name, $options);
        return $this;
    }
}

/**
 * @param string $name
 * @param string $value
 * @param array $options
 * @param bool $raw
 * @return bool
 */
function emit(string $name, string $value, array $options, bool $raw = false) : bool
{
    return $raw ? setrawcookie($name, $value, $options) : setcookie($name, $value, $options);
}

/**
 * @param int|string $expires
 * @return int
 */
function expires($expires) : int
{
    return (int) (is_string($expires) ? strtotime($expires) : $expires);
}

/**
 * @param array $option
 * @param array $default
 * @return array
 */
function options(array $option, array $default = []) : array
{
    return [
        EXPIRES => (int) expires($option[EXPIRES] ?? $default[EXPIRES] ?? 0),
        PATH => (string) ($option[PATH] ?? $default[PATH] ?? '/'),
        DOMAIN => (string) ($option[DOMAIN] ?? $default[DOMAIN] ?? ''),
        SECURE => (bool) ($option[SECURE] ?? $default[SECURE] ?? false),
        HTTP_ONLY => (bool) ($option[HTTP_ONLY] ?? $default[HTTP_ONLY] ?? true),
        SAMESITE => (string) ($option[SAMESITE] ?? $default[SAMESITE] ?? 'lax')
    ];
}

/**
 * @param array $cookie
 * @param array $defaults
 * @return bool
 */
function send(array $cookie, array $defaults = []) : bool
{
    return emit((string) $cookie[NAME], (string) $cookie[VALUE],
        options($cookie[OPTIONS] ?? $cookie, $defaults), $cookie[RAW] ?? false);
}
