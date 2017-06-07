<?php
/**
 *
 */

namespace Mvc5\Response;

interface Response
    extends \Mvc5\Http\Response
{
    /**
     * @return \Mvc5\Cookie\Cookies
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
    function withCookie($name, $value = '', $expire = null, $path = null, $domain = null, $secure = null, $httponly = null);

    /**
     * @param array|\Mvc5\Cookie\Cookies $cookies
     * @return mixed|self
     */
    function withCookies($cookies);

    /**
     * @param string $name
     * @param array|string $value
     * @return mixed|self
     */
    function withHeader($name, $value);

    /**
     * @param array|\Mvc5\Http\Headers $headers
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
