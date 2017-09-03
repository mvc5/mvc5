<?php
/**
 *
 */

namespace Mvc5\Request;

interface Request
    extends \Mvc5\Http\Request
{
    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    function arg(string $name, $default = null);

    /**
     * @return array
     */
    function args() : array;

    /**
     * @return string|null
     */
    function clientAddress();

    /**
     * @return callable|mixed
     */
    function controller();

    /**
     * @param string $name
     * @return array|string|null
     */
    function cookie(string $name);

    /**
     * @return array|\Mvc5\Cookie\Cookies
     */
    function cookies();

    /**
     * @param string|null $name
     * @param mixed $default
     * @return array|mixed
     */
    function data(string $name = null, $default = null);

    /**
     * @return \Mvc5\Http\Error|null
     */
    function error();

    /**
     * @return array|mixed
     */
    function files();

    /**
     * @param string $name
     * @return array|string|null
     */
    function header(string $name);

    /**
     * @return string|null
     */
    function host();

    /**
     * @return bool
     */
    function isPost() : bool;

    /**
     * @return bool
     */
    function isSecure() : bool;

    /**
     * @return bool
     */
    function isXmlHttpRequest() : bool;

    /**
     * @return string|null
     */
    function name();

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    function param(string $name, $default = null);

    /**
     * @return array
     */
    function params() : array;

    /**
     * @return string
     */
    function path();

    /**
     * @return int|null
     */
    function port();

    /**
     * @param string|null $name
     * @param mixed $default
     * @return array|mixed
     */
    function post(string $name = null, $default = null);

    /**
     * @return array|string|null
     */
    function query();

    /**
     * @return \Mvc5\Route\Route|null
     */
    function route();

    /**
     * @return string
     */
    function scheme();

    /**
     * @param string|null $name
     * @param mixed $default
     * @return array|mixed
     */
    function server(string $name = null, $default = null);

    /**
     * @param string|null $name
     * @param mixed $default
     * @return array|\Mvc5\Session\Session|mixed
     */
    function session(string $name = null, $default = null);

    /**
     * @return string|mixed
     */
    function user();

    /**
     * @return string|null
     */
    function userAgent();

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    function var(string $name, $default = null);

    /**
     * @return array
     */
    function vars() : array;
}
