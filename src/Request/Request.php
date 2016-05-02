<?php
/**
 *
 */

namespace Mvc5\Request;

use Mvc5\Cookie\Cookies;
use Mvc5\Http\Request as HttpRequest;
use Mvc5\Response\Error;

interface Request
    extends HttpRequest
{
    /**
     * @param $name
     * @return mixed
     */
    function arg($name);

    /**
     * @return array
     */
    function args();

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    function attr($name, $value);

    /**
     * @return mixed
     */
    function clientAddress();

    /**
     * @return string
     */
    function contentType();

    /**
     * @return array|callable|null|object|string
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
     * @return mixed
     */
    function data($name = null);

    /**
     * @return Error
     */
    function error();

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
     * @return mixed
     */
    function param($name);

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
     * @return mixed
     */
    function post($name = null);

    /**
     * @return string
     */
    function query();

    /**
     * @return string|string[]
     */
    function scheme();

    /**
     * @param $name
     * @return array|\ArrayAccess
     */
    function server($name = null);

    /**
     * @param $name
     * @return mixed
     */
    function session($name = null);

    /**
     * @return resource
     */
    function stream();

    /**
     * @return mixed
     */
    function user();
}
