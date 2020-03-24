<?php
/**
 *
 */

namespace Mvc5\Request\Config;

use Mvc5\ArrayObject;
use Mvc5\Config\Model;
use Mvc5\Cookie\Cookies;
use Mvc5\Cookie\HttpCookies;
use Mvc5\Http;
use Mvc5\Route\Route;

use function is_array;
use function is_string;

use const Mvc5\{ ACCEPTS_JSON, ARGS, AUTHENTICATED, CLIENT_ADDRESS, COOKIES, CONTROLLER, DATA, ERROR, FILES,
    HEADERS, HOST, NAME, PARAMS, PATH, PORT, QUERY, ROUTE, SCHEME, SERVER, SESSION, URI, USER, USER_AGENT };

trait Request
{
    /**
     *
     */
    use Http\Config\Request;

    /**
     * @param array|Model $config
     */
    function __construct($config = [])
    {
        $config[COOKIES] ??= new HttpCookies;

        is_array($config[COOKIES]) &&
            $config[COOKIES] = new HttpCookies($config[COOKIES]);

        $config[HEADERS] ??= new Http\HttpHeaders;

        is_array($config[HEADERS]) &&
            $config[HEADERS] = new Http\HttpHeaders($config[HEADERS]);

        isset($config[URI]) && !($config[URI] instanceof Http\Uri) &&
            $config[URI] = new Http\HttpUri($config[URI]);

        $this->config = $config instanceof Model ? $config: new ArrayObject((array) $config);
    }

    /**
     * @return bool
     */
    function authenticated() : bool
    {
        return (bool) $this[AUTHENTICATED];
    }

    /**
     * @return bool
     */
    function acceptsJson() : bool
    {
        return (bool) $this[ACCEPTS_JSON];
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
        return $this[ARGS] ?? [];
    }

    /**
     * @return string|null
     */
    function clientAddress() : ?string
    {
        return $this[CLIENT_ADDRESS];
    }

    /**
     * @return callable|mixed
     */
    function controller()
    {
        return $this[CONTROLLER];
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
        return $this[COOKIES];
    }

    /**
     * @param array|string|null $name
     * @param mixed $default
     * @return mixed
     */
    function data($name = null, $default = null)
    {
        return null === $name ? ($this->get(DATA) ?: []) : match($this->get(DATA) ?: [], $name, $default);
    }

    /**
     * @return Http\Error|null
     */
    function error() : ?Http\Error
    {
        return $this[ERROR];
    }

    /**
     * @return array|mixed
     */
    function files()
    {
        return $this[FILES] ?? [];
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
        return $this->get(URI)[HOST] ?? null;
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
        return $this[NAME];
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
        return $this[PARAMS] ?? [];
    }

    /**
     * @return string|null
     */
    function path() : ?string
    {
        return $this->get(URI)[PATH] ?? null;
    }

    /**
     * @return int|null
     */
    function port() : ?int
    {
        return $this->get(URI)[PORT] ?? null;
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
        return $this->get(URI)[QUERY] ?? null;
    }

    /**
     * @return Route|null
     */
    function route() : ?Route
    {
        return $this[ROUTE];
    }

    /**
     * @return string|null
     */
    function scheme() : ?string
    {
        return $this->get(URI)[SCHEME] ?? null;
    }

    /**
     * @param array|string|null $name
     * @param mixed $default
     * @return array|mixed
     */
    function server($name = null, $default = null)
    {
        return null === $name ? $this->get(SERVER) : match($this->get(SERVER), $name, $default);
    }

    /**
     * @param array|string|null $name
     * @param mixed $default
     * @return \Mvc5\Session\Session|mixed
     */
    function session($name = null, $default = null)
    {
        return null === $name ? $this->get(SESSION) : match($this->get(SESSION), $name, $default);
    }

    /**
     * @return string|mixed
     */
    function user()
    {
        return $this[USER];
    }

    /**
     * @return string|null
     */
    function userAgent() : ?string
    {
        return $this[USER_AGENT];
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
 * @param mixed|null $default
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
