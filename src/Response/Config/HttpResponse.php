<?php
/**
 *
 */

namespace Mvc5\Response\Config;

use Mvc5\Arg;
use Mvc5\Cookie\Cookies;
use Mvc5\Cookie\HttpCookies;
use Mvc5\Http\Headers;
use Mvc5\Http\HttpHeaders;
use Mvc5\Response\Response;

trait HttpResponse
{
    /**
     *
     */
    use \Mvc5\Http\Config\Response;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @param mixed $body
     * @param int|null $status
     * @param array|Headers $headers
     * @param array $config
     */
    function __construct($body = null, int $status = null, $headers = [], array $config = [])
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
    function cookies() : Cookies
    {
        return $this[Arg::COOKIES];
    }

    /**
     * @param string|string[] $name
     * @return string|string[]
     */
    function header($name)
    {
        return $this->headers()->header($name);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param int|null $expire
     * @param string|null $path
     * @param string|null $domain
     * @param bool|null $secure
     * @param bool|null $httponly
     * @return self|mixed
     */
    function withCookie($name, $value = null, $expire = null,
                        string $path = null, string $domain = null, bool $secure = null, bool $httponly = null) : Response
    {
        return $this->withCookies($this->cookies()->with($name, $value, $expire, $path, $domain, $secure, $httponly));
    }

    /**
     * @param array|Cookies $cookies
     * @return self|mixed
     */
    function withCookies($cookies) : Response
    {
        return $this->with(Arg::COOKIES, $cookies instanceof Cookies ? $cookies : new HttpCookies($cookies));
    }

    /**
     * @param string $name
     * @param string $value
     * @return self|mixed
     */
    function withHeader($name, $value) : Response
    {
        return $this->with(Arg::HEADERS, $this->headers()->with((string) $name, $value));
    }

    /**
     * @param array|Headers $headers
     * @return self|mixed
     */
    function withHeaders($headers) : Response
    {
        return $this->with(Arg::HEADERS, $headers instanceof Headers ? $headers : new HttpHeaders($headers));
    }

    /**
     * @param int $status
     * @param string $reason
     * @return self|mixed
     */
    function withStatus($status, $reason = '') : Response
    {
        return $this->with([Arg::STATUS => (int) $status, Arg::REASON => (string) $reason]);
    }

    /**
     * @param string $version
     * @return self|mixed
     */
    function withVersion(string $version) : Response
    {
        return $this->with(Arg::VERSION, $version);
    }
}
