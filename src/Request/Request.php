<?php
/**
 *
 */

namespace Mvc5\Request;

use Mvc5\Http\Error;

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
    function clientAddress() : ?string;

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
     * @return Error|null
     */
    function error() : ?Error;

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
     * @return string|null
     */
    function path() : ?string;

    /**
     * @return int|null
     */
    function port() : ?int;

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
     * @return string|null
     */
    function scheme() : ?string;

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
    function userAgent() : ?string;

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
