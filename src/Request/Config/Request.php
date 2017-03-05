<?php
/**
 *
 */

namespace Mvc5\Request\Config;

use Mvc5\Arg;
use Mvc5\Http\Config\Request as HttpRequest;
use Mvc5\Http\Error;
use Mvc5\Route\Route;

trait Request
{
    /**
     *
     */
    use HttpRequest;

    /**
     * @param $name
     * @param null $default
     * @return mixed
     */
    function arg($name, $default = null)
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
     * @return mixed
     */
    function contentType()
    {
        return $this[Arg::CONTENT_TYPE];
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
    function cookie($name)
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
     * @param $name
     * @param null $default
     * @return mixed
     */
    function data($name = null, $default = null)
    {
        return null === $name ? ($this[Arg::DATA] ?: []) : ($this->get(Arg::DATA)[$name] ?? $default);
    }

    /**
     * @return Error
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
     * @param $name
     * @return string
     */
    function header($name)
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
     * @param $name
     * @param null $default
     * @return mixed
     */
    function param($name, $default = null)
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
        return $this->get(Arg::URI)[Arg::PATH] ?? Arg::SEPARATOR;
    }

    /**
     * @return int|null|string
     */
    function port()
    {
        return $this->get(Arg::URI)[Arg::PORT] ?? null;
    }

    /**
     * @param $name
     * @param null $default
     * @return array
     */
    function post($name = null, $default = null)
    {
        return $this->data($name, $default);
    }

    /**
     * @return string
     */
    function query()
    {
        return $this->get(Arg::URI)[Arg::QUERY] ?? null;
    }

    /**
     * @return Route
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
        return $this->get(Arg::URI)[Arg::SCHEME] ?? null;
    }

    /**
     * @param $name
     * @param null $default
     * @return array|\ArrayAccess
     */
    function server($name = null, $default = null)
    {
        return null === $name ? ($this[Arg::SERVER] ?: []) : ($this->get(Arg::SERVER)[$name] ?? $default);
    }

    /**
     * @param $name
     * @param null $default
     * @return array|\ArrayAccess
     */
    function session($name = null, $default = null)
    {
        return null === $name ? ($this[Arg::SESSION] ?: []) : ($this->get(Arg::SESSION)[$name] ?? $default);
    }

    /**
     * @return resource
     */
    function stream()
    {
        return $this[Arg::STREAM];
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
     * @param $name
     * @param null $default
     * @return mixed
     */
    function variable($name, $default = null)
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
