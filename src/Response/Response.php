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
    function cookies() : Cookies;

    /**
     * @param array|string $name
     * @return array|string
     */
    function header($name);

    /**
     * @param array|string $name
     * @param string|null $value
     * @param array $options
     * @return Response
     */
    function withCookie($name, $value = null, array $options = []) : Response;

    /**
     * @param array|string $name
     * @param array $options
     * @return Response
     */
    function withoutCookie($name, array $options = []) : Response;

    /**
     * @param array|\Mvc5\Cookie\Cookies $cookies
     * @return Response
     */
    function withCookies($cookies) : Response;

    /**
     * @param string $name
     * @param array|string $value
     * @return Response
     */
    function withHeader($name, $value) : Response;

    /**
     * @param array|\Mvc5\Http\Headers $headers
     * @return Response
     */
    function withHeaders($headers) : Response;

    /**
     * @param int $status
     * @param string $reason
     * @return Response
     */
    function withStatus($status, $reason = '') : Response;

    /**
     * @param string $version
     * @return Response
     */
    function withVersion(string $version) : Response;
}
