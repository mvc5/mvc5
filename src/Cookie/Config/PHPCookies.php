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
    function __construct(array $cookies = null, array $defaults = [])
    {
        $this->config = $cookies ?? $_COOKIE;
        $this->defaults = $defaults + $this->defaults;
    }

    /**
     * @param string     $name
     * @param string     $value
     * @param int        $expire
     * @param string     $path
     * @param string     $domain
     * @param bool|false $secure
     * @param bool|true  $httponly
     * @return mixed
     */
    function set($name, $value = '', $expire = null, $path = null, $domain = null, $secure = null, $httponly = null)
    {
        setcookie(...array_values($this->cookie($name, $value, $expire, $path, $domain, $secure, $httponly)));
        return $value;
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
    function with($name, $value = '', $expire = null, $path = null, $domain = null, $secure = null, $httponly = null)
    {
        $this->set($name, $value, $expire, $path, $domain, $secure, $httponly);
        return $this;
    }

    /**
     * @param string     $name
     * @param string     $path
     * @param string     $domain
     * @param bool|false $secure
     * @param bool|true  $httponly
     * @return self|mixed
     */
    function without($name, $path = null, $domain = null, $secure = null, $httponly = null)
    {
        $this->remove($name, $path, $domain, $secure, $httponly);
        return $this;
    }
}
