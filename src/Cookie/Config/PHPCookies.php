<?php
/**
 *
 */

namespace Mvc5\Cookie\Config;

use Mvc5\Arg;
use Mvc5\Cookie;

trait PHPCookies
{
    /**
     *
     */
    use Cookies;

    /**
     * @param array|null $cookies
     * @param array $defaults
     */
    function __construct(array $cookies = null, array $defaults = [])
    {
        $this->config = $cookies ?? $_COOKIE;
        $this->defaults = $defaults + $this->defaults;
    }

    /**
     * @param string $name
     * @param string $value
     * @param int|string|null $expire
     * @param string|null $path
     * @param string|null $domain
     * @param bool|null $secure
     * @param bool|null $httponly
     * @return array
     */
    protected static function args($name, $value = '', $expire = null, string $path = null,
                                   string $domain = null, bool $secure = null, bool $httponly = null) : array
    {
        return [
            (string) $name, (string) $value, (int) (is_string($expire) ? strtotime($expire) : $expire),
            $path ?? '/', (string) $domain, (bool) $secure, $httponly ?? true
        ];
    }

    /**
     * @param array $cookie
     * @return array
     */
    protected static function named(array $cookie) : array
    {
        return static::args(
            $cookie[Arg::NAME],
            $cookie[Arg::VALUE],
            $cookie[Arg::EXPIRE] ?? null,
            $cookie[Arg::PATH] ?? null,
            $cookie[Arg::DOMAIN] ?? null,
            $cookie[Arg::SECURE] ?? null,
            $cookie[Arg::HTTP_ONLY] ?? null
        );
    }

    /**
     * @param array $cookie
     * @return bool
     */
    static function send(array $cookie) : bool
    {
        return setcookie(...(is_string(key($cookie)) ? static::named($cookie) : static::args(...$cookie)));
    }

    /**
     * @param string $name
     * @param string $value
     * @param int|string|null $expire
     * @param string|null $path
     * @param string|null $domain
     * @param bool|null $secure
     * @param bool|null $httponly
     * @return mixed
     */
    function set($name, $value = '', $expire = null,
                 string $path = null, string $domain = null, bool $secure = null, bool $httponly = null)
    {
        $this->send($this->cookie($name, $value, $expire, $path, $domain, $secure, $httponly));
        return $value;
    }

    /**
     * @param string $name
     * @param string $value
     * @param int|string|null $expire
     * @param string|null $path
     * @param string|null $domain
     * @param bool|null $secure
     * @param bool|null $httponly
     * @return self|mixed
     */
    function with($name, $value = '', $expire = null,
                  string $path = null, string $domain = null, bool $secure = null, bool $httponly = null) : Cookie\Cookies
    {
        $this->set($name, $value, $expire, $path, $domain, $secure, $httponly);
        return $this;
    }

    /**
     * @param string $name
     * @param string|null $path
     * @param string|null $domain
     * @param bool|null $secure
     * @param bool|null $httponly
     * @return self|mixed
     */
    function without($name, string $path = null, string $domain = null, bool $secure = null, bool $httponly = null) : Cookie\Cookies
    {
        $this->remove($name, $path, $domain, $secure, $httponly);
        return $this;
    }
}
