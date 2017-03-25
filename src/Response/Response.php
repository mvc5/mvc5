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
     * @return Cookies
     */
    function cookies();

    /**
     * @param array|string $name
     * @param string       $value
     * @param int          $expire
     * @param string       $path
     * @param string       $domain
     * @param bool|false   $secure
     * @param bool|false   $httponly
     * @return mixed|self
     */
    function withCookie($name, $value = null, $expire = null, $path = null, $domain = null, $secure = null, $httponly = null);

    /**
     * @param array|Cookies $cookies
     * @return mixed|self
     */
    function withCookies($cookies);

    /**
     * @param string $name
     * @param string $value
     * @return mixed|self
     */
    function withHeader($name, $value);

    /**
     * @param array|Headers $headers
     * @return mixed|self
     */
    function withHeaders($headers);

    /**
     * @param int $status
     * @param string $reason
     * @return mixed|self
     */
    function withStatus($status, $reason = '');

    /**
     * @param string $version
     * @return mixed|self
     */
    function withVersion($version);
}
