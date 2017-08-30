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
    function args()
    {
        return $this[Arg::ARGS] ?: [];
    }

    /**
     * @return mixed
     */
    function clientAddress()
    {
        return $this[Arg::CLIENT_ADDRESS];
    }

    /**
     * @return array|callable|null|object|string
     */
    function controller()
    {
        return $this[Arg::CONTROLLER];
    }

    /**
     * @param $name
     * @return array|\ArrayAccess
     */
    function cookie(string $name)
    {
        return $this->get(Arg::COOKIES)[$name] ?? null;
    }

    /**
     * @return array|\ArrayAccess
     */
    function cookies()
    {
        return $this[Arg::COOKIES] ?: [];
    }

    /**
     * @param null|string $name
     * @param mixed $default
     * @return mixed
     */
    function data(string $name = null, $default = null)
    {
        return null === $name ? ($this[Arg::DATA] ?: []) : ($this->get(Arg::DATA)[$name] ?? $default);
    }

    /**
     * @return null|\Mvc5\Http\Error
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
        return $this[Arg::FILES] ?: [];
    }

    /**
     * @param string $name
     * @return array|string
     */
    function header(string $name)
    {
        return $this->get(Arg::HEADERS)[$name] ?? null;
    }

    /**
     * @return string|string[]
     */
    function host()
    {
        return $this->get(Arg::URI)[Arg::HOST] ?? null;
    }

    /**
     * @return bool
     */
    function isPost()
    {
        return 'POST' === $this->method();
    }

    /**
     * @return bool
     */
    function isSecure()
    {
        return 'https' === $this->scheme();
    }

    /**
     * @return bool
     */
    function isXmlHttpRequest()
    {
        return 'XMLHttpRequest' == $this->header('X-Requested-With');
    }

    /**
     * @return string
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
    function params()
    {
        return $this[Arg::PARAMS] ?: [];
    }

    /**
     * @return string
     */
    function path()
    {
        return $this->get(Arg::URI)[Arg::PATH] ?? '';
    }

    /**
     * @return int|null|string
     */
    function port()
    {
        return $this->get(Arg::URI)[Arg::PORT] ?? null;
    }

    /**
     * @param null|string $name
     * @param mixed $default
     * @return array
     */
    function post(string $name = null, $default = null)
    {
        return $this->data($name, $default);
    }

    /**
     * @return string
     */
    function query()
    {
        return $this->get(Arg::URI)[Arg::QUERY] ?? '';
    }

    /**
     * @return \Mvc5\Route\Route
     */
    function route()
    {
        return $this[Arg::ROUTE];
    }

    /**
     * @return string|string[]
     */
    function scheme()
    {
        return $this->get(Arg::URI)[Arg::SCHEME] ?? '';
    }

    /**
     * @param null|string $name
     * @param mixed $default
     * @return array|\ArrayAccess
     */
    function server(string $name = null, $default = null)
    {
        return null === $name ? ($this[Arg::SERVER] ?: []) : ($this->get(Arg::SERVER)[$name] ?? $default);
    }

    /**
     * @param null|string $name
     * @param mixed $default
     * @return array|\ArrayAccess
     */
    function session(string $name = null, $default = null)
    {
        return null === $name ? ($this[Arg::SESSION] ?: []) : ($this->get(Arg::SESSION)[$name] ?? $default);
    }

    /**
     * @return mixed
     */
    function user()
    {
        return $this[Arg::USER];
    }

    /**
     * @return mixed
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
    function vars()
    {
        return $this->params() + $this->args() + $this->data();
    }
}
