<?php
/**
 *
 */

namespace Mvc5\Request\Config;

use Mvc5\Arg;
use Mvc5\Http\Config\Request as HttpRequest;
use Mvc5\Http\Error;

trait Request
{
    /**
     *
     */
    use HttpRequest;

    /**
     * @param $name
     * @return mixed
     */
    function arg($name)
    {
        return $this->get(Arg::ARGS)[$name] ?? null;
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
     * @return mixed
     */
    function data($name = null)
    {
        return null === $name ? ($this[Arg::DATA] ?: []) : ($this->get(Arg::DATA)[$name] ?? null);
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
     * @return mixed
     */
    function param($name)
    {
        return $this->get(Arg::PARAMS)[$name] ?? null;
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
     * @return array
     */
    function post($name = null)
    {
        return $this->data($name);
    }

    /**
     * @return string
     */
    function query()
    {
        return $this->get(Arg::URI)[Arg::QUERY] ?? null;
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
     * @return array|\ArrayAccess
     */
    function server($name = null)
    {
        return null === $name ? ($this[Arg::SERVER] ?: []) : ($this->get(Arg::SERVER)[$name] ?? null);
    }

    /**
     * @param $name
     * @return array|\ArrayAccess
     */
    function session($name = null)
    {
        return null === $name ? ($this[Arg::SESSION] ?: []) : ($this->get(Arg::SESSION)[$name] ?? null);
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
     * @return mixed
     */
    function variable($name)
    {
        return $this->param($name) ?? $this->arg($name) ?? $this->data($name);
    }

    /**
     * @return array
     */
    function vars()
    {
        return $this->params() + $this->args() + $this->data();
    }
}
