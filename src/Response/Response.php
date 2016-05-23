<?php
/**
 *
 */

namespace Mvc5\Response;

use Mvc5\Cookie\Cookies;
use Mvc5\Http\Headers;
use Mvc5\Http\Response as HttpResponse;

interface Response
    extends HttpResponse
{
    /**
     * @param $body
     * @return mixed
     */
    function body($body = null);

    /**
     * @param string     $name
     * @param string     $value
     * @param int        $expire
     * @param string     $path
     * @param string     $domain
     * @param bool|false $secure
     * @param bool|false $httponly
     * @return mixed
     */
    function cookie($name, $value, $expire = null, $path = null, $domain = null, $secure = null, $httponly = null);

    /**
     * @param array|Cookies $cookies
     * @return array|Cookies
     */
    function cookies($cookies = null);

    /**
     * @param string $name
     * @param string $value
     * @param bool $replace
     * @return string
     */
    function header($name, $value, $replace = false);

    /**
     * @param array|Headers $headers
     * @return array|Headers
     */
    function headers($headers = null);

    /**
     * @param $status
     * @return int
     */
    function status($status = null);

    /**
     * @param $version
     * @return int
     */
    function version($version = null);
}
