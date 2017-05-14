<?php
/**
 *
 */

namespace Mvc5\Cookie\Config;

use Mvc5\Arg;

trait Cookies
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var array
     */
    protected $defaults = [
        Arg::EXPIRE    => 0,
        Arg::PATH      => '/',
        Arg::DOMAIN    => '',
        Arg::SECURE    => false,
        Arg::HTTP_ONLY => true
    ];

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
     * @param $name
     * @param $value
     * @param $expire
     * @param $path
     * @param $domain
     * @param $secure
     * @param $httponly
     * @return array
     */
    protected function cookie($name, $value, $expire, $path, $domain, $secure, $httponly)
    {
        return [
            $name,
            $value,
            $expire   ?? $this->defaults[Arg::EXPIRE],
            $path     ?? $this->defaults[Arg::PATH],
            $domain   ?? $this->defaults[Arg::DOMAIN],
            $secure   ?? $this->defaults[Arg::SECURE],
            $httponly ?? $this->defaults[Arg::HTTP_ONLY]
        ];
    }

    /**
     * @param string     $name
     * @param string     $path
     * @param string     $domain
     * @param bool|false $secure
     * @param bool|true  $httponly
     * @return bool
     */
    function remove($name, $path = null, $domain = null, $secure = null, $httponly = null)
    {
        return $this->set($name, '', 946706400, $path, $domain, $secure, $httponly);
    }

    /**
     * @param string     $name
     * @param string     $value
     * @param int        $expire
     * @param string     $path
     * @param string     $domain
     * @param bool|false $secure
     * @param bool|true  $httponly
     * @return bool
     */
    function set($name, $value = '', $expire = null, $path = null, $domain = null, $secure = null, $httponly = null)
    {
        return $this->setCookie($this->cookie($name, $value, $expire, $path, $domain, $secure, $httponly));
    }

    /**
     * @param array $cookie
     * @return bool
     */
    protected function setCookie(array $cookie)
    {
        return \setcookie(...array_values($cookie));
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
    function with($name, $value = null, $expire = null, $path = null, $domain = null, $secure = null, $httponly = null)
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
