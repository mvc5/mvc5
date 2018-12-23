<?php
/**
 *
 */

namespace Mvc5\Cookie\Config;

use Mvc5\Arg;
use Mvc5\Cookie\Cookies;

use function array_values;
use function is_array;
use function is_string;
use function key;
use function setcookie;
use function setrawcookie;
use function strtotime;

trait PHPCookies
{
    /**
     *
     */
    use HttpCookies;

    /**
     * @var array
     */
    protected $defaults = [];

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
        is_string($cookie) &&
            $cookie = [Arg::NAME => $cookie] + $options;

        return static::send([Arg::VALUE => '', Arg::EXPIRES => 946706400] +
            (is_string(key($cookie)) ? $cookie : cookie(...$cookie)));
    }

    /**
     * @param array $cookie
     * @param array $defaults
     * @return bool
     */
    static function send(array $cookie, array $defaults = []) : bool
    {
        return send(is_string(key($cookie)) ? $cookie : cookie(...$cookie), $defaults);
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $options
     * @return mixed
     */
    function set($name, $value = '', array $options = [])
    {
        if (is_array($name)) {
            $this->send($name, $this->defaults);
            return $name;
        }

        $this->send([Arg::NAME => (string) $name, Arg::VALUE => (string) $value] + $options, $this->defaults);

        return $value;
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param array $options
     * @return self|mixed
     */
    function with($name, $value = null, array $options = []) : Cookies
    {
        $this->set($name, $value, $options);
        return $this;
    }

    /**
     * @param string $name
     * @param array $options
     * @return self|mixed
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
    if (isset($options[Arg::SAMESITE])) {
        return $raw ? setrawcookie($name, $value, $options) : setcookie($name, $value, $options);
    }

    return $raw ? setrawcookie($name, $value, ...array_values($options)) : setcookie($name, $value, ...array_values($options));
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
 * @param array $cookie
 * @param array $defaults
 * @param bool $samesite
 * @return array
 */
function options(array $cookie, array $defaults = [], bool $samesite = true) : array
{
    return [
        Arg::EXPIRES => (int) expires($cookie[Arg::EXPIRES] ?? $defaults[Arg::EXPIRES] ?? 0),
        Arg::PATH => (string) ($cookie[Arg::PATH] ?? $defaults[Arg::PATH] ?? '/'),
        Arg::DOMAIN => (string) ($cookie[Arg::DOMAIN] ?? $defaults[Arg::DOMAIN] ?? ''),
        Arg::SECURE => (bool) ($cookie[Arg::SECURE] ?? $defaults[Arg::SECURE] ?? false),
        Arg::HTTP_ONLY => (bool) ($cookie[Arg::HTTP_ONLY] ?? $defaults[Arg::HTTP_ONLY] ?? true)
    ] + ($samesite ? [Arg::SAMESITE => (string) ($cookie[Arg::SAMESITE] ?? $defaults[Arg::SAMESITE] ?? '')] : []);
}

/**
 * @return bool
 */
function php73() : bool
{
    return \version_compare(\PHP_VERSION, '7.3', '>=');
}

/**
 * @param array $cookie
 * @param array $defaults
 * @return bool
 */
function send(array $cookie, array $defaults = []) : bool
{
    return emit((string) $cookie[Arg::NAME], (string) $cookie[Arg::VALUE],
        options($cookie, $defaults, php73()), $cookie[Arg::RAW] ?? false);
}
