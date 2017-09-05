<?php
/**
 *
 */

namespace Mvc5\Cookie\Config;

use Mvc5\Arg;
use Mvc5\Cookie;

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
     * @param string $name
     * @param string $value
     * @param int|string|null $expire
     * @param string|null $path
     * @param string|null $domain
     * @param bool|null $secure
     * @param bool|null $httponly
     * @return array
     */
    protected function cookie($name, $value, $expire = null,
                              string $path = null, string $domain = null, bool $secure = null, bool $httponly = null) : array
    {
        return [
            Arg::NAME => (string) $name,
            Arg::VALUE => (string) $value,
            Arg::EXPIRE => is_string($expire ?? $expire = $this->defaults[Arg::EXPIRE]) ? $expire : (int) $expire,
            Arg::PATH => $path ?? $this->defaults[Arg::PATH],
            Arg::DOMAIN => $domain ?? $this->defaults[Arg::DOMAIN],
            Arg::SECURE => $secure ?? $this->defaults[Arg::SECURE],
            Arg::HTTP_ONLY => $httponly ?? $this->defaults[Arg::HTTP_ONLY]
        ];
    }

    /**
     * @param string $name
     * @param string|null $path
     * @param string|null $domain
     * @param bool|null $secure
     * @param bool|null $httponly
     */
    function remove($name, string $path = null, string $domain = null, bool $secure = null, bool $httponly = null)
    {
        $this->set($name, '', 946706400, $path, $domain, $secure, $httponly);
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
        $this->config[$name] = $this->cookie($name, $value, $expire, $path, $domain, $secure, $httponly);
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
        $new = clone $this;
        $new->set($name, $value, $expire, $path, $domain, $secure, $httponly);
        return $new;
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
        $new = clone $this;
        $new->remove($name, $path, $domain, $secure, $httponly);
        return $new;
    }
}
