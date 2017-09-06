<?php
/**
 *
 */

namespace Mvc5\Response;

use Mvc5\Cookie\Cookies;

interface Response
    extends \Mvc5\Http\Response
{
    /**
     * @return Cookies
     */
    function cookies();

    /**
     * @param array|string $name
     * @param string $value
     * @param int $expire
     * @param string|null $path
     * @param string|null $domain
     * @param bool|null $secure
     * @param bool|null $httponly
     * @return self|mixed
     */
    function withCookie($name, $value = '', $expire = null, string $path = null, string $domain = null, bool $secure = null, bool $httponly = null);

    /**
     * @param array|\Mvc5\Cookie\Cookies $cookies
     * @return self|mixed
     */
    function withCookies($cookies);

    /**
     * @param string $name
     * @param array|string $value
     * @return self|mixed
     */
    function withHeader($name, $value);

    /**
     * @param array|\Mvc5\Http\Headers $headers
     * @return self|mixed
     */
    function withHeaders($headers);

    /**
     * @param int $status
     * @param string $reason
     * @return self|mixed
     */
    function withStatus($status, $reason = '');

    /**
     * @param string $version
     * @return self|mixed
     */
    function withVersion(string $version);
}
