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
     * @param $body
     * @return string
     */
    function body($body = null)
    {
        return func_num_args() ? $this[Arg::BODY] = $body : $this[Arg::BODY];
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
    function cookie($name, $value, $expire = null, $path = null, $domain = null, $secure = null, $httponly = null)
    {
        return $this->with(
            Arg::COOKIES, $this->cookies()->withCookie($name, $value, $expire, $path, $domain, $secure, $httponly)
        );
    }

    /**
     * @param $cookies
     * @return HttpCookies|self|mixed
     */
    function cookies($cookies = null)
    {
        return null === $cookies ? $this[Arg::COOKIES] :
            $this->with(Arg::COOKIES, $cookies instanceof HttpCookies ? $cookies : new Cookies($cookies));
    }

    /**
     * @param string $name
     * @param string $value
     * @return self|mixed
     */
    function header($name, $value)
    {
        return $this->with(Arg::HEADERS, $this->headers()->with($name, $value));
    }

    /**
     * @param $headers
     * @return self|mixed|Headers
     */
    function headers($headers = null)
    {
        return null === $headers ? $this[Arg::HEADERS] :
            $this->with(Arg::HEADERS, $headers instanceof HttpHeaders ? $headers : new Headers($headers));
    }

    /**
     * @param $status
     * @return self|mixed|string
     */
    function status($status = null)
    {
        return null === $status ? $this[Arg::STATUS] : $this->with(Arg::STATUS, $status);
    }

    /**
     * @param $version
     * @return self|mixed|string
     */
    function version($version = null)
    {
        return null === $version ? $this[Arg::VERSION] : $this->with(Arg::VERSION, $version);
    }
}
