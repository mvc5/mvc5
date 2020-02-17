<?php
/**
 *
 */

namespace Mvc5\Request\Config;

use Mvc5\Arg;
use Mvc5\Cookie\Cookies;
use Mvc5\Cookie\HttpCookies;
use Mvc5\Http;
use Mvc5\Route\Route;

use function is_array;
use function is_string;

trait Request
{
    /**
     *
     */
    use Http\Config\Request;

    /**
     * @param array $config
     */
    function __construct($config = [])
    {
        $config[Arg::COOKIES] ??= new HttpCookies;

        is_array($config[Arg::COOKIES]) &&
            $config[Arg::COOKIES] = new HttpCookies($config[Arg::COOKIES]);

        $config[Arg::HEADERS] ??= new Http\HttpHeaders;

        is_array($config[Arg::HEADERS]) &&
            $config[Arg::HEADERS] = new Http\HttpHeaders($config[Arg::HEADERS]);

        isset($config[Arg::URI]) && !($config[Arg::URI] instanceof Http\Uri) &&
            $config[Arg::URI] = new Http\HttpUri($config[Arg::URI]);

        $this->config = $config;
    }

    /**
     * @return bool
     */
    function authenticated() : bool
    {
        return (bool) $this[Arg::AUTHENTICATED];
    }

    /**
     * @return bool
     */
    function acceptsJson() : bool
    {
        return (bool) $this[Arg::ACCEPTS_JSON];
    }

    /**
     * @param array|string $name
     * @param mixed $default
     * @return mixed
     */
    function arg($name, $default = null)
    {
        return match($this->args(), $name, $default);
    }

    /**
     * @return array
     */
    function args() : array
    {
        return $this[Arg::ARGS] ?? [];
    }

    /**
     * @return string|null
     */
    function clientAddress() : ?string
    {
        return $this[Arg::CLIENT_ADDRESS];
    }

    /**
     * @return callable|mixed
     */
    function controller()
    {
        return $this[Arg::CONTROLLER];
    }

    /**
     * @param array|string $name
     * @return array|string|null
     */
    function cookie($name)
    {
        return match($this->cookies(), $name);
    }

    /**
     * @return Cookies
     */
    function cookies() : Cookies
    {
        return $this[Arg::COOKIES];
    }

    /**
     * @param array|string|null $name
     * @param mixed $default
     * @return mixed
     */
    function data($name = null, $default = null)
    {
        return null === $name ? ($this->get(Arg::DATA) ?: []) : match($this->get(Arg::DATA) ?: [], $name, $default);
    }

    /**
     * @return Http\Error|null
     */
    function error() : ?Http\Error
    {
        return $this[Arg::ERROR];
    }

    /**
     * @return array|mixed
     */
    function files()
    {
        return $this[Arg::FILES] ?? [];
    }

    /**
     * @param string|string[] $name
     * @return string|string[]
     */
    function header($name)
    {
        return $this->headers()->header($name);
    }

    /**
     * @return string|null
     */
    function host() : ?string
    {
        return $this->get(Arg::URI)[Arg::HOST] ?? null;
    }

    /**
     * @return bool
     */
    function isPost() : bool
    {
        return 'POST' === $this->method();
    }

    /**
     * @return bool
     */
    function isSecure() : bool
    {
        return 'https' === $this->scheme();
    }

    /**
     * @return bool
     */
    function isXmlHttpRequest() : bool
    {
        return 'XMLHttpRequest' == $this->header('X-Requested-With');
    }

    /**
     * @return string|null
     */
    function name() : ?string
    {
        return $this[Arg::NAME];
    }

    /**
     * @param array|string $name
     * @param mixed $default
     * @return mixed
     */
    function param($name, $default = null)
    {
        return match($this->params(), $name, $default);
    }

    /**
     * @return array
     */
    function params() : array
    {
        return $this[Arg::PARAMS] ?? [];
    }

    /**
     * @return string|null
     */
    function path() : ?string
    {
        return $this->get(Arg::URI)[Arg::PATH] ?? null;
    }

    /**
     * @return int|null
     */
    function port() : ?int
    {
        return $this->get(Arg::URI)[Arg::PORT] ?? null;
    }

    /**
     * @param array|string|null $name
     * @param mixed $default
     * @return array|mixed
     */
    function post($name = null, $default = null)
    {
        return $this->data($name, $default);
    }

    /**
     * @return array|string|null
     */
    function query()
    {
        return $this->get(Arg::URI)[Arg::QUERY] ?? null;
    }

    /**
     * @return Route|null
     */
    function route() : ?Route
    {
        return $this[Arg::ROUTE];
    }

    /**
     * @return string|null
     */
    function scheme() : ?string
    {
        return $this->get(Arg::URI)[Arg::SCHEME] ?? null;
    }

    /**
     * @param array|string|null $name
     * @param mixed $default
     * @return array|mixed
     */
    function server($name = null, $default = null)
    {
        return null === $name ? $this->get(Arg::SERVER) : match($this->get(Arg::SERVER), $name, $default);
    }

    /**
     * @param array|string|null $name
     * @param mixed $default
     * @return \Mvc5\Session\Session|mixed
     */
    function session($name = null, $default = null)
    {
        return null === $name ? $this->get(Arg::SESSION) : match($this->get(Arg::SESSION), $name, $default);
    }

    /**
     * @return string|mixed
     */
    function user()
    {
        return $this[Arg::USER];
    }

    /**
     * @return string|null
     */
    function userAgent() : ?string
    {
        return $this[Arg::USER_AGENT];
    }

    /**
     * @param array|string $name
     * @param mixed $default
     * @return mixed
     */
    function var($name, $default = null)
    {
        if (is_string($name)) {
            return $this->param($name) ?? $this->arg($name) ?? $this->data($name, $default);
        }

        $matched = [];

        foreach($name as $key) {
            $matched[$key] = $this->param($key) ?? $this->arg($key) ?? $this->data($key);
        }

        return $matched;
    }

    /**
     * @return array
     */
    function vars() : array
    {
        return $this->params() + $this->args() + $this->data();
    }
}

/**
 * @param array|\ArrayAccess $data
 * @param array|string $name
 * @param null $default
 * @return mixed
 */
function match($data, $name, $default = null)
{
    if (is_string($name)) {
        return $data[$name] ?? $default;
    }

    $matched = [];

    foreach($name as $key) {
        $matched[$key] = $data[$key] ?? null;
    }

    return $matched;
}
