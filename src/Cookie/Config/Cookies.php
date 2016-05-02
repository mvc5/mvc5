<?php
/**
 *
 */

namespace Mvc5\Cookie\Config;

use Mvc5\Cookie\Cookies as CookieJar;

trait Cookies
{
    /**
     *
     */
    use Container;

    /**
     * @var CookieJar
     */
    protected $container;

    /**
     * @param CookieJar $container
     * @param array $config
     */
    function __construct(CookieJar $container, array $config = [])
    {
        $this->config = $config;

        $this->container = $container;
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
        $this->container->remove($name, $path, $domain, $secure, $httponly);
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
        return $this->container->set($name, $value, $expire, $path, $domain, $secure, $httponly);
    }
}
