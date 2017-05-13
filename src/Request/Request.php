<?php
/**
 *
 */

namespace Mvc5\Request;

interface Request
    extends \Mvc5\Http\Request
{
    /**
     * @param $name
     * @param null $default
     * @return mixed
     */
    function arg($name, $default = null);

    /**
     * @return array
     */
    function args();

    /**
     * @return string
     */
    function clientAddress();

    /**
     * @return array|callable|mixed|null|object|string
     */
    function controller();

    /**
     * @param $name
     * @return mixed
     */
    function cookie($name);

    /**
     * @return array|\Mvc5\Http\Cookies
     */
    function cookies();

    /**
     * @param $name
     * @param null $default
     * @return array|mixed
     */
    function data($name = null, $default = null);

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
     * @return string
     */
    function header($name);

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
     * @param $name
     * @param null $default
     * @return mixed
     */
    function param($name, $default = null);

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
     * @param $name
     * @param null $default
     * @return array|mixed
     */
    function post($name = null, $default = null);

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
     * @param $name
     * @param null $default
     * @return array|mixed
     */
    function server($name = null, $default = null);

    /**
     * @param $name
     * @param null $default
     * @return array|mixed|\Mvc5\Session\Session
     */
    function session($name = null, $default = null);

    /**
     * @return mixed
     */
    function user();

    /**
     * @return string
     */
    function userAgent();

    /**
     * @param $name
     * @param null $default
     * @return mixed
     */
    function var($name, $default = null);

    /**
     * @return array
     */
    function vars();
}
