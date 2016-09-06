<?php
/**
 *
 */

namespace Mvc5\Cookie\Config;

use Mvc5\Cookie\Cookies as _Cookies;

trait Cookies
{
    /**
     *
     */
    use Container;

    /**
     * @var _Cookies
     */
    protected $cookies;

    /**
     * @param _Cookies $cookies
     * @param array $config
     */
    function __construct(_Cookies $cookies, array $config = [])
    {
        $this->config = $config;
        $this->cookies = $cookies;
    }

    /**
     * @param string     $name
     * @param string     $path
     * @param string     $domain
     * @param bool|false $secure
     * @param bool|true  $httponly
     */
    function remove($name, $path = null, $domain = null, $secure = null, $httponly = null)
    {
        $this->cookies->remove($name, $path, $domain, $secure, $httponly);
    }

    /**
     * @param string     $name
     * @param string     $value
     * @param int        $expire
     * @param string     $path
     * @param string     $domain
     * @param bool|false $secure
     * @param bool|true  $httponly
     * @return string
     */
    function set($name, $value, $expire = null, $path = null, $domain = null, $secure = null, $httponly = null)
    {
        return $this->cookies->set($name, $value, $expire, $path, $domain, $secure, $httponly);
    }
}
