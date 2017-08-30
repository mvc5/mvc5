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
     * @param string $value
     * @param int $expire
     * @param null|string $path
     * @param null|string $domain
     * @param bool|null $secure
     * @param bool|null $httponly
     * @return mixed|self
     */
    function withCookie($name, $value = '', $expire = null, string $path = null, string $domain = null, bool $secure = null, bool $httponly = null);

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
    function withVersion(string $version);
}
