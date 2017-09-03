<?php
/**
 *
 */

namespace Mvc5\Cookie\Config;

use Mvc5\Arg;

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
            $path ?? '/', (string) $domain, $secure ?? false, $httponly ?? true
        ];
    }

    /**
     * @param array $cookie
     * @return array
     */
    protected static function named(array $cookie) : array
    {
        return [
            (string) $cookie[Arg::NAME],
            (string) $cookie[Arg::VALUE],
            (int) (($expire = $cookie[Arg::EXPIRE] ?? 0) && is_string($expire) ? strtotime($expire) : $expire),
            $cookie[Arg::PATH] ?? '/',
            (string) ($cookie[Arg::DOMAIN] ?? ''),
            $cookie[Arg::SECURE] ?? false,
            $cookie[Arg::HTTP_ONLY] ?? true
        ];
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
                  string $path = null, string $domain = null, bool $secure = null, bool $httponly = null)
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
    function without($name, string $path = null, string $domain = null, bool $secure = null, bool $httponly = null)
    {
        $this->remove($name, $path, $domain, $secure, $httponly);
        return $this;
    }
}
