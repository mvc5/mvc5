<?php
/**
 *
 */

namespace Mvc5\Request\Config;

use Mvc5\Arg;
use Mvc5\Http\Error;
use Mvc5\Route\Route;

trait Request
{
    /**
     *
     */
    use \Mvc5\Http\Config\Request;

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
     * @return array|\Mvc5\Cookie\Cookies
     */
    function cookies()
    {
        return $this[Arg::COOKIES] ?? [];
    }

    /**
     * @param array|string|null $name
     * @param mixed $default
     * @return mixed
     */
    function data($name = null, $default = null)
    {
        $data = $this->get(Arg::DATA) ?: [];

        return null === $name ? $data : match($data, $name, $default);
    }

    /**
     * @return Error|null
     */
    function error() : ?Error
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
     * @param array|string $name
     * @return array|string|null
     */
    function header($name)
    {
        return match($this->headers(), $name);
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
        $server = $this->get(Arg::SERVER);

        return null === $name ? $server : match($server, $name, $default);
    }

    /**
     * @param array|string|null $name
     * @param mixed $default
     * @return \Mvc5\Session\Session|mixed
     */
    function session($name = null, $default = null)
    {
        $session = $this->get(Arg::SESSION);

        return null === $name ? $session : match($session, $name, $default);
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
 * @return array|null
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
