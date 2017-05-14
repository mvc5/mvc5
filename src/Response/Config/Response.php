<?php
/**
 *
 */

namespace Mvc5\Response\Config;

use Mvc5\Arg;
use Mvc5\Http\Cookies;
use Mvc5\Http\Headers;
use Mvc5\Http\HttpCookies;
use Mvc5\Http\HttpHeaders;

trait Response
{
    /**
     *
     */
    use \Mvc5\Http\Config\Response;

    /**
     * @var array|mixed
     */
    protected $config = [];

    /**
     * @param null $body
     * @param string $status
     * @param array $headers
     * @param array $config
     */
    function __construct($body = null, $status = null, $headers = [], array $config = [])
    {
        !isset($config[Arg::COOKIES]) &&
            $config[Arg::COOKIES] = new HttpCookies;

        !($config[Arg::COOKIES] instanceof Cookies) &&
            $config[Arg::COOKIES] = new HttpCookies($config[Arg::COOKIES]);

        $config[Arg::HEADERS] = $headers instanceof Headers ? $headers : new HttpHeaders($headers);
        $config[Arg::STATUS] = $status;
        $config[Arg::BODY] = $body;

        $this->config = $config;
    }

    /**
     * @return Cookies
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
    function withCookie($name, $value = '', $expire = null, $path = null, $domain = null, $secure = null, $httponly = null)
    {
        return $this->withCookies($this->cookies()->withCookie($name, $value, $expire, $path, $domain, $secure, $httponly));
    }

    /**
     * @param $cookies
     * @return self|mixed
     */
    function withCookies($cookies)
    {
        return $this->with(Arg::COOKIES, $cookies instanceof Cookies ? $cookies : new HttpCookies($cookies));
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
     * @return self|mixed
     */
    function withHeaders($headers)
    {
        return $this->with(Arg::HEADERS, $headers instanceof Headers ? $headers : new HttpHeaders($headers));
    }

    /**
     * @param $status
     * @param $reason
     * @return self|mixed
     */
    function withStatus($status, $reason = '')
    {
        return $this->with([Arg::STATUS => $status, Arg::REASON => $reason]);
    }

    /**
     * @param $version
     * @return self|mixed
     */
    function withVersion($version)
    {
        return $this->with(Arg::VERSION, $version);
    }
}
