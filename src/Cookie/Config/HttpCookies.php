<?php
/**
 *
 */

namespace Mvc5\Cookie\Config;

use Mvc5\Arg;
use Mvc5\Cookie\Cookies;

use function is_array;
use function is_string;
use function key;
use function strtotime;

trait HttpCookies
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
        Arg::HTTP_ONLY => true,
        Arg::SAMESITE  => ''
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
     * @return array
     */
    function all() : array
    {
        return $this->config;
    }

    /**
     * @param array|string $name
     * @param array $options
     */
    function remove($name, array $options = []) : void
    {
        !is_array($name) ? $this->set($name, '', [Arg::EXPIRE => 946706400] + $options) : $this->set(
            [Arg::VALUE => '', Arg::EXPIRE => 946706400] + (is_string(key($name)) ? $name : cookie(...$name))
        );
    }

    /**
     * @param array|string $name
     * @param string|null $value
     * @param array $options
     * @return mixed
     */
    function set($name, $value = null, array $options = [])
    {
        if (is_array($name)) {
            $this->config[name($name)] = is_string(key($name)) ? $name : cookie(...$name);
            return $name;
        }

        $this->config[$name] = [Arg::NAME => (string) $name, Arg::VALUE => (string) $value] + $options;

        return $value;
    }

    /**
     * @param array|string $name
     * @param string|null $value
     * @param array $options
     * @return self|mixed
     */
    function with($name, $value = null, array $options = []) : Cookies
    {
        $new = clone $this;
        $new->set($name, $value, $options);
        return $new;
    }

    /**
     * @param array|string $name
     * @param array $options
     * @return self|mixed
     */
    function without($name, array $options = []) : Cookies
    {
        $new = clone $this;
        $new->remove($name, $options);
        return $new;
    }
}

/**
 * @param string $name
 * @param string $value
 * @param null $expire
 * @param string|null $path
 * @param string|null $domain
 * @param bool|null $secure
 * @param bool|null $httponly
 * @param string $samesite
 * @return array
 */
function cookie(string $name, string $value, $expire = null,
                string $path = null, string $domain = null, bool $secure = null, bool $httponly = null, string $samesite = '') : array
{
    return [
        Arg::NAME => $name,
        Arg::VALUE => $value,
        Arg::EXPIRE => $expire,
        Arg::PATH => $path,
        Arg::DOMAIN => $domain,
        Arg::SECURE => $secure,
        Arg::HTTP_ONLY => $httponly,
        Arg::SAMESITE => $samesite
    ];
}

/**
 * @param int|string $expire
 * @return int
 */
function expire($expire) : int
{
    return (int) (is_string($expire) ? strtotime($expire) : $expire);
}

/**
 * @param $name
 * @return string
 */
function name($name) : string
{
    return (string) (is_array($name) ? (is_string(key($name)) ? $name[Arg::NAME] : $name[0]) : $name);
}

/**
 * @param array $options
 * @param array $defaults
 * @param bool $samesite
 * @return array
 */
function options(array $options, array $defaults = [], bool $samesite = true) : array
{
    return [
        Arg::EXPIRE => (int) expire($options[Arg::EXPIRE] ?? $defaults[Arg::EXPIRE] ?? 0),
        Arg::PATH => (string) ($options[Arg::PATH] ?? $defaults[Arg::PATH] ?? '/'),
        Arg::DOMAIN => (string) ($options[Arg::DOMAIN] ?? $defaults[Arg::DOMAIN] ?? ''),
        Arg::SECURE => (bool) ($options[Arg::SECURE] ?? $defaults[Arg::SECURE] ?? false),
        Arg::HTTP_ONLY => (bool) ($options[Arg::HTTP_ONLY] ?? $defaults[Arg::HTTP_ONLY] ?? true)
    ] + ($samesite ? [Arg::SAMESITE => (string) ($options[Arg::SAMESITE] ?? $defaults[Arg::SAMESITE] ?? '')] : []);
}
