<?php
/**
 *
 */

namespace Mvc5\Response\Config;

use Mvc5\Arg;
use Mvc5\Cookie\Cookies;
use Mvc5\Cookie\Container as CookieJar;
use Mvc5\Http\Config\Response as HttpResponse;
use Mvc5\Response\Headers as ResponseHeaders;
use Mvc5\Response\Headers\Config as HeadersConfig;

trait Response
{
    /**
     *
     */
    use HttpResponse;

    /**
     * @param null $body
     * @param string $status
     * @param array $headers
     * @param array $config
     */
    function __construct($body = null, $status = null, $headers = [], array $config = [])
    {
        $this->config = [
            Arg::BODY    => $body,
            Arg::COOKIES => $config[Arg::COOKIES] ?? new CookieJar,
            Arg::HEADERS => $headers instanceof HeadersConfig ? $headers : new HeadersConfig($headers),
            Arg::STATUS  => $status
        ] + $config;
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
     * @param bool|true $httponly
     * @return mixed
     */
    function cookie($name, $value, $expire = null, $path = null, $domain = null, $secure = null, $httponly = null)
    {
        return $this->cookies()->set($name, $value, $expire, $path, $domain, $secure, $httponly);
    }

    /**
     * @param $cookies
     * @return array|Cookies
     */
    function cookies($cookies = null)
    {
        return null !== $cookies ? $this[Arg::COOKIES] = $cookies : $this[Arg::COOKIES];
    }

    /**
     * @param string $name
     * @param string $value
     * @param bool $replace
     * @return string
     */
    function header($name, $value, $replace = false)
    {
        if ($replace) {
            unset($this[Arg::HEADERS][$name]);
        }

        return $this[Arg::HEADERS][$name] = $value;
    }

    /**
     * @param $headers
     * @return array|ResponseHeaders
     */
    function headers($headers = null)
    {
        return null !== $headers ? $this[Arg::HEADERS] = $headers : $this[Arg::HEADERS];
    }

    /**
     * @param $status
     * @return string
     */
    function status($status = null)
    {
        return null !== $status ? $this[Arg::STATUS] = $status : $this[Arg::STATUS];
    }

    /**
     * @param $version
     * @return string
     */
    function version($version = null)
    {
        return null !== $version ? $this[Arg::VERSION] = $version : $this[Arg::VERSION];
    }
}
