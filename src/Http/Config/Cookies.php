<?php
/**
 *
 */

namespace Mvc5\Http\Config;

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
    function __construct(array $cookies = [], array $defaults = [])
    {
        $this->config = $cookies;
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
            Arg::NAME      => $name,
            Arg::VALUE     => $value,
            Arg::EXPIRE    => $expire   ?? $this->defaults[Arg::EXPIRE],
            Arg::PATH      => $path     ?? $this->defaults[Arg::PATH],
            Arg::DOMAIN    => $domain   ?? $this->defaults[Arg::DOMAIN],
            Arg::SECURE    => $secure   ?? $this->defaults[Arg::SECURE],
            Arg::HTTP_ONLY => $httponly ?? $this->defaults[Arg::HTTP_ONLY]
        ];
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
    function withCookie($name, $value = '', $expire = null, $path = null, $domain = null, $secure = null, $httponly = null)
    {
        return $this->with($name, $this->cookie($name, $value, $expire, $path, $domain, $secure, $httponly));
    }

    /**
     * @param string     $name
     * @param string     $path
     * @param string     $domain
     * @param bool|false $secure
     * @param bool|true  $httponly
     * @return self|mixed
     */
    function withoutCookie($name, $path = null, $domain = null, $secure = null, $httponly = null)
    {
        return $this->withCookie($name, '', 946706400, $path, $domain, $secure, $httponly);
    }
}
