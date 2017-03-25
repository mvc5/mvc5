<?php
/**
 *
 */

namespace Mvc5\Request;

use Mvc5\Cookie\Cookies;
use Mvc5\Http\Error as HttpError;
use Mvc5\Http\Request as HttpRequest;
use Mvc5\Session\Session;
use Mvc5\Route\Route;

interface Request
    extends HttpRequest
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
     * @return string
     */
    function contentType();

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
     * @return array|Cookies
     */
    function cookies();

    /**
     * @param $name
     * @param null $default
     * @return array|mixed
     */
    function data($name = null, $default = null);

    /**
     * @return HttpError|mixed
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
     * @return Route
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
     * @return array|mixed|Session
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
    function variable($name, $default = null);

    /**
     * @return array
     */
    function vars();
}
