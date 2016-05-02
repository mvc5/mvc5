<?php
/**
 *
 */

namespace Mvc5\Request\Config;

use Mvc5\Arg;
use Mvc5\Http\Config\Request as HttpRequest;
use Mvc5\Response\Error;

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
        return $this[Arg::ARGS][$name] ?? null;
    }

    /**
     * @return array
     */
    function args()
    {
        return $this[Arg::ARGS] ?? [];
    }

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    function attr($name, $value)
    {
        return $this->config[Arg::PARAMS][$name] = $value;
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
        return $this[Arg::COOKIES][$name] ?? null;
    }

    /**
     * @return array|\ArrayAccess
     */
    function cookies()
    {
        return $this[Arg::COOKIES] ?? [];
    }

    /**
     * @param $name
     * @return mixed
     */
    function data($name = null)
    {
        return null === $name ? ($this[Arg::DATA] ?? []) : ($this[Arg::DATA][$name] ?? null);
    }

    /**
     * @return Error
     */
    function error()
    {
        return $this[Arg::ERROR];
    }

    /**
     * @param $name
     * @return string
     */
    function header($name)
    {
        return $this->headers()[$name] ?? null;
    }

    /**
     * @return string|string[]
     */
    function host()
    {
        return $this[Arg::URI][Arg::HOST] ?? null;
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
        return $this[Arg::PARAMS][$name] ?? $this->arg($name) ?? $this->data($name);
    }

    /**
     * @return array
     */
    function params()
    {
        return ($this[Arg::PARAMS] ?: []) + $this->args() + $this->data();
    }

    /**
     * @return string
     */
    function path()
    {
        return $this[Arg::URI][Arg::PATH] ?? Arg::SEPARATOR;
    }

    /**
     * @return int|null|string
     */
    function port()
    {
        return $this[Arg::URI][Arg::PORT] ?? null;
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
        return $this[Arg::URI][Arg::QUERY] ?? null;
    }

    /**
     * @return string|string[]
     */
    function scheme()
    {
        return $this[Arg::URI][Arg::SCHEME] ?? null;
    }

    /**
     * @param $name
     * @return array|\ArrayAccess
     */
    function server($name = null)
    {
        return null === $name ? ($this[Arg::SERVER] ?? []) : ($this[Arg::SERVER][$name] ?? null);
    }

    /**
     * @param $name
     * @return array|\ArrayAccess
     */
    function session($name = null)
    {
        return null === $name ? ($this[Arg::SESSION] ?? []) : ($this[Arg::SESSION][$name] ?? null);
    }

    /**
     * @return resource
     */
    function stream()
    {
        return $this[ARG::STREAM];
    }

    /**
     * @return mixed
     */
    function user()
    {
        return $this[Arg::USER];
    }
}
