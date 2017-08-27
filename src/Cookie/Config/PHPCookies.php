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
     * @param array $cookies
     * @param array $defaults
     */
    function __construct(array $cookies = [], array $defaults = [])
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
     * @param bool|false $secure
     * @param bool|true $httponly
     * @return mixed
     */
    function set($name, $value = '', $expire = null,
                 string $path = null, string $domain = null, bool $secure = null, bool $httponly = null)
    {
        setcookie(...array_values($this->cookie($name, $value, $expire, $path, $domain, $secure, $httponly)));
        return $value;
    }

    /**
     * @param string $name
     * @param string $value
     * @param int|null|string $expire
     * @param null|string $path
     * @param null|string $domain
     * @param bool|false $secure
     * @param bool|true $httponly
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
     * @param bool|false $secure
     * @param bool|true $httponly
     * @return self|mixed
     */
    function without($name, string $path = null, string $domain = null, bool $secure = null, bool $httponly = null)
    {
        $this->remove($name, $path, $domain, $secure, $httponly);
        return $this;
    }
}
