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
    function args();

    /**
     * @return string
     */
    function clientAddress();

    /**
     * @return mixed|callable
     */
    function controller();

    /**
     * @param string $name
     * @return array|\ArrayAccess
     */
    function cookie(string $name);

    /**
     * @return array|\Mvc5\Cookie\Cookies
     */
    function cookies();

    /**
     * @param string $name
     * @param mixed $default
     * @return array|mixed
     */
    function data(string $name = null, $default = null);

    /**
     * @return \Mvc5\Http\Error|mixed
     */
    function error();

    /**
     * @return array|mixed
     */
    function files();

    /**
     * @param string $name
     * @return array|string
     */
    function header(string $name);

    /**
     * @return string
     */
    function host();

    /**
     * @return bool
     */
    function isPost();

    /**
     * @return bool
     */
    function isSecure();

    /**
     * @return bool
     */
    function isXmlHttpRequest();

    /**
     * @return string
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
    function params();

    /**
     * @return string
     */
    function path();

    /**
     * @return int|null|string
     */
    function port();

    /**
     * @param string $name
     * @param mixed $default
     * @return array|mixed
     */
    function post(string $name = null, $default = null);

    /**
     * @return string
     */
    function query();

    /**
     * @return \Mvc5\Route\Route
     */
    function route();

    /**
     * @return string
     */
    function scheme();

    /**
     * @param string $name
     * @param mixed $default
     * @return array|mixed
     */
    function server(string $name = null, $default = null);

    /**
     * @param string $name
     * @param mixed $default
     * @return array|mixed|\Mvc5\Session\Session
     */
    function session(string $name = null, $default = null);

    /**
     * @return mixed
     */
    function user();

    /**
     * @return string
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
    function vars();
}
