<?php
/**
 *
 */

namespace Mvc5\Cookie\Config;

use Mvc5\Config\Config;

trait Container
{
    /**
     *
     */
    use Config;

    /**
     * @var array
     */
    protected $defaults = [
        'expire'   => 0,
        'path'     => '/',
        'domain'   => '',
        'secure'   => false,
        'httponly' => true
    ];

    /**
     * @param array $defaults
     */
    function __construct(array $defaults = [])
    {
        $defaults && $this->defaults = $defaults + $this->defaults;
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
            'name'     => $name,
            'value'    => $value,
            'expire'   => $expire   ?? $this->defaults['expire'],
            'path'     => $path     ?? $this->defaults['path'],
            'domain'   => $domain   ?? $this->defaults['domain'],
            'secure'   => $secure   ?? $this->defaults['secure'],
            'httponly' => $httponly ?? $this->defaults['httponly']
        ];
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
        $this->setCookie($name, false, 946706400, $path, $domain, $secure, $httponly);
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
        $this->setCookie($name, $value, $expire, $path, $domain, $secure, $httponly);

        return $value;
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
    protected function setCookie($name, $value, $expire, $path, $domain, $secure, $httponly)
    {
        return $this->config[$name] = $this->cookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }
}
