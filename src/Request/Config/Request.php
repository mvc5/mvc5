<?php
/**
 *
 */

namespace Mvc5\Request\Config;

use Mvc5\Arg;

trait Request
{
    /**
     *
     */
    use \Mvc5\Http\Config\Request;

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    function arg(string $name, $default = null)
    {
        return $this->get(Arg::ARGS)[$name] ?? $default;
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
    function clientAddress()
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
     * @param string $name
     * @return array|string|null
     */
    function cookie(string $name)
    {
        return $this->get(Arg::COOKIES)[$name] ?? null;
    }

    /**
     * @return array|\Mvc5\Cookie\Cookies
     */
    function cookies()
    {
        return $this[Arg::COOKIES] ?? [];
    }

    /**
     * @param string|null $name
     * @param mixed $default
     * @return mixed
     */
    function data(string $name = null, $default = null)
    {
        return null === $name ? ($this[Arg::DATA] ?: []) : ($this->get(Arg::DATA)[$name] ?? $default);
    }

    /**
     * @return \Mvc5\Http\Error|null
     */
    function error()
    {
        return $this[Arg::ERROR];
    }

    /**
     * @return array
     */
    function files()
    {
        return $this[Arg::FILES] ?? [];
    }

    /**
     * @param string $name
     * @return array|string|null
     */
    function header(string $name)
    {
        return $this->get(Arg::HEADERS)[$name] ?? null;
    }

    /**
     * @return string|null
     */
    function host()
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
    function name()
    {
        return $this[Arg::NAME];
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    function param(string $name, $default = null)
    {
        return $this->get(Arg::PARAMS)[$name] ?? $default;
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
    function path()
    {
        return $this->get(Arg::URI)[Arg::PATH] ?? null;
    }

    /**
     * @return int|null
     */
    function port()
    {
        return $this->get(Arg::URI)[Arg::PORT] ?? null;
    }

    /**
     * @param string|null $name
     * @param mixed $default
     * @return array|mixed
     */
    function post(string $name = null, $default = null)
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
     * @return \Mvc5\Route\Route|null
     */
    function route()
    {
        return $this[Arg::ROUTE];
    }

    /**
     * @return string|null
     */
    function scheme()
    {
        return $this->get(Arg::URI)[Arg::SCHEME] ?? null;
    }

    /**
     * @param string|null $name
     * @param mixed $default
     * @return array|mixed
     */
    function server(string $name = null, $default = null)
    {
        return null === $name ? ($this[Arg::SERVER] ?? []) : ($this->get(Arg::SERVER)[$name] ?? $default);
    }

    /**
     * @param string|null $name
     * @param mixed $default
     * @return \Mvc5\Session\Session|mixed
     */
    function session(string $name = null, $default = null)
    {
        return null === $name ? ($this[Arg::SESSION] ?? []) : ($this->get(Arg::SESSION)[$name] ?? $default);
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
    function userAgent()
    {
        return $this[Arg::USER_AGENT];
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    function var(string $name, $default = null)
    {
        return $this->param($name) ?? $this->arg($name) ?? $this->data($name, $default);
    }

    /**
     * @return array
     */
    function vars() : array
    {
        return $this->params() + $this->args() + $this->data();
    }
}
