<?php
/**
 *
 */

namespace Mvc5\Response\Config;

use Mvc5\Arg;
use Mvc5\Http\Cookies as HttpCookies;
use Mvc5\Http\Cookies\Config as Cookies;
use Mvc5\Http\Config\Response as _Response;
use Mvc5\Http\Headers as HttpHeaders;
use Mvc5\Http\Headers\Config as Headers;

trait Response
{
    /**
     *
     */
    use _Response;

    /**
     * @param null $body
     * @param string $status
     * @param array $headers
     * @param array $config
     */
    function __construct($body = null, $status = null, $headers = [], array $config = [])
    {
        !isset($config[Arg::COOKIES]) &&
            $config[Arg::COOKIES] = new Cookies;

        !($config[Arg::COOKIES] instanceof HttpCookies) &&
            $config[Arg::COOKIES] = new Cookies($config[Arg::COOKIES]);

        $config[Arg::HEADERS] = $headers instanceof HttpHeaders ? $headers : new Headers($headers);
        $config[Arg::STATUS] = $status;
        $config[Arg::BODY] = $body;

        $this->config = $config;
    }

    /**
     * @return HttpCookies
     */
    function cookies()
    {
        return $this[Arg::COOKIES];
    }

    /**
     * @param string     $name
     * @param string     $value
     * @param int        $expire
     * @param string     $path
     * @param string     $domain
     * @param bool|false $secure
     * @param bool|true  $httponly
     * @return self|mixed
     */
    function withCookie($name, $value = null, $expire = null, $path = null, $domain = null, $secure = null, $httponly = null)
    {
        return $this->withCookies($this->cookies()->withCookie($name, $value, $expire, $path, $domain, $secure, $httponly));
    }

    /**
     * @param $cookies
     * @return HttpCookies|self|mixed
     */
    function withCookies($cookies)
    {
        return $this->with(Arg::COOKIES, $cookies instanceof HttpCookies ? $cookies : new Cookies($cookies));
    }

    /**
     * @param string $name
     * @param string $value
     * @return self|mixed
     */
    function withHeader($name, $value)
    {
        return $this->with(Arg::HEADERS, $this->headers()->with($name, $value));
    }

    /**
     * @param $headers
     * @return self|mixed|Headers
     */
    function withHeaders($headers)
    {
        return $this->with(Arg::HEADERS, $headers instanceof HttpHeaders ? $headers : new Headers($headers));
    }

    /**
     * @param $version
     * @return self|mixed|string
     */
    function withProtocolVersion($version)
    {
        return $this->with(Arg::VERSION, $version);
    }

    /**
     * @param $status
     * @param $reason
     * @return self|mixed|string
     */
    function withStatus($status, $reason = '')
    {
        return $this->with([Arg::STATUS => $status, Arg::REASON => $reason]);
    }
}
