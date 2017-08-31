<?php
/**
 *
 */

namespace Mvc5\Cookie\Config;

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
     * @param int|null|string $expire
     * @param null|string $path
     * @param null|string $domain
     * @param bool|null $secure
     * @param bool|null $httponly
     * @return mixed
     */
    protected static function params($name, $value = '', $expire = null, string $path = null,
                                     string $domain = null, bool $secure = null, bool $httponly = null)
    {
        return [
            (string) $name, (string) $value, (int) (is_string($expire) ? strtotime($expire) : $expire),
            $path ?? '/', (string) $domain, $secure ?? false, $httponly ?? true
        ];
    }

    /**
     * @param array $cookie
     * @return bool
     */
    static function send(array $cookie)
    {
        return setcookie(...static::params(...array_values($cookie)));
    }

    /**
     * @param string $name
     * @param string $value
     * @param int|null|string $expire
     * @param null|string $path
     * @param null|string $domain
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
     * @param int|null|string $expire
     * @param null|string $path
     * @param null|string $domain
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
     * @param null|string $path
     * @param null|string $domain
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
