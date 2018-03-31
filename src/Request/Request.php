<?php
/**
 *
 */

namespace Mvc5\Request;

use Mvc5\Http\Error;
use Mvc5\Route\Route;

interface Request
    extends \Mvc5\Http\Request
{
    /**
     * @param array|string $name
     * @param mixed $default
     * @return mixed
     */
    function arg($name, $default = null);

    /**
     * @return array
     */
    function args() : array;

    /**
     * @return string|null
     */
    function clientAddress() : ?string;

    /**
     * @return callable|mixed
     */
    function controller();

    /**
     * @param array|string $name
     * @return array|string|null
     */
    function cookie($name);

    /**
     * @return array|\Mvc5\Cookie\Cookies
     */
    function cookies();

    /**
     * @param array|string|null $name
     * @param mixed $default
     * @return array|mixed
     */
    function data($name = null, $default = null);

    /**
     * @return Error|null
     */
    function error() : ?Error;

    /**
     * @return array|mixed
     */
    function files();

    /**
     * @param array|string $name
     * @return array|string|null
     */
    function header($name);

    /**
     * @return string|null
     */
    function host() : ?string;

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
    function name() : ?string;

    /**
     * @param array|string $name
     * @param mixed $default
     * @return mixed
     */
    function param($name, $default = null);

    /**
     * @return array
     */
    function params() : array;

    /**
     * @return string|null
     */
    function path() : ?string;

    /**
     * @return int|null
     */
    function port() : ?int;

    /**
     * @param array string|null $name
     * @param mixed $default
     * @return array|mixed
     */
    function post($name = null, $default = null);

    /**
     * @return array|string|null
     */
    function query();

    /**
     * @return Route|null
     */
    function route() : ?Route;

    /**
     * @return string|null
     */
    function scheme() : ?string;

    /**
     * @param array|string|null $name
     * @param mixed $default
     * @return array|mixed
     */
    function server($name = null, $default = null);

    /**
     * @param array|string|null $name
     * @param mixed $default
     * @return array|\Mvc5\Session\Session|mixed
     */
    function session($name = null, $default = null);

    /**
     * @return string|mixed
     */
    function user();

    /**
     * @return string|null
     */
    function userAgent() : ?string;

    /**
     * @param array|string $name
     * @param mixed $default
     * @return mixed
     */
    function var($name, $default = null);

    /**
     * @return array
     */
    function vars() : array;
}
