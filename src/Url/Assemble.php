<?php
/**
 *
 */

namespace Mvc5\Url;

use Mvc5\Arg;
use Mvc5\Http\Uri;

class Assemble
{
    /**
     *
     */
    const FRAGMENT = self::UNRESERVED + ['%2B' => '+', '%26' => '&', '%3F' => '?', '%23' => '#'];

    /**
     *
     */
    const PATH = self::UNRESERVED + ['%2B' => '+', '%26' => '&'];

    /**
     *
     */
    const QUERY = self::UNRESERVED + ['%3F' => '?'];

    /**
     *
     */
    const QUERY_STRING = self::QUERY + ['%26' => '&'];

    /**
     *
     */
    const UNRESERVED = [
        '%2F' => '/', '%5B' => '[', '%5D' => ']', '%3A' => ':', '%40' => '@', '%21' => '!', '%24' => '$',
        '%27' => "'", '%28' => '(', '%29' => ')', '%2A' => '*', '%2C' => ',', '%3B' => ';', '%3D' => '='
    ];

    /**
     * @param $host
     * @param int|null $port
     * @param string $user
     * @param string $password
     * @return string
     */
    static function authority($host, $port = null, $user = '', $password = '')
    {
        return static::user($user, $password, '@') . static::host($host) . static::port($port, ':');
    }

    /**
     * @param string $scheme
     * @param string $authority
     * @param string $path
     * @param string $query
     * @param string $fragment
     * @return string
     */
    static function compile($scheme, $authority, $path, $query, $fragment)
    {
        return ($scheme ? $scheme . ':' : '') . ($scheme || $authority ? '//' : '') . $authority .
            $path . ($query ? '?' . $query : '') . ($fragment ? '#' . $fragment : '');
    }

    /**
     * @param string $value
     * @param array $unreserved
     * @return string
     */
    static function encode($value, array $unreserved = [])
    {
        return $value ? strtr(rawurlencode($value), $unreserved ?: static::UNRESERVED) : (string) $value;
    }

    /**
     * @param string $value
     * @return string
     */
    static function fragment($value)
    {
        return static::encode($value, static::FRAGMENT);
    }

    /**
     * @param string $host
     * @return string
     */
    static function host($host)
    {
        return static::encode(strtolower($host));
    }

    /**
     * @param string $path
     * @return string
     */
    static function path($path)
    {
        return static::encode($path, static::PATH);
    }

    /**
     * @param string $port
     * @param string $prefix
     * @return string
     */
    static function port($port, $prefix = '')
    {
        return $port && 80 != $port && 443 != $port ? $prefix . (int) $port : null;
    }

    /**
     * @param array|string $query
     * @return string
     */
    static function query($query)
    {
        return !$query ? $query : (is_string($query) ? static::encode($query, static::QUERY_STRING) : strtr(
            http_build_query($query, '', Arg::QUERY_SEPARATOR, \PHP_QUERY_RFC3986), static::QUERY
        ));
    }

    /**
     * @param string $scheme
     * @return string
     */
    static function scheme($scheme)
    {
        return strtolower($scheme);
    }

    /**
     * @param string|Uri $path
     * @param array|string $query
     * @return string
     */
    static function target($path = '', $query = '')
    {
        return $path instanceof Uri ? static::url($path->path() ?: '/', $path->query()) :
            static::url($path ?: '/', $query);
    }

    /**
     * @param Uri $uri
     * @return string
     */
    static function uri(Uri $uri)
    {
        return static::compile(
            static::scheme($uri->scheme()),
            static::authority($uri->host(), $uri->port(), $uri->user(), $uri->password()),
            static::path($uri->path()),
            static::query($uri->query()),
            static::fragment($uri->fragment())
        );
    }

    /**
     * @param string $path
     * @param array|string $query
     * @param string $fragment
     * @param array $options
     * @return string
     */
    static function url($path, $query = '', $fragment = '', array $options = [])
    {
        return static::compile(
            static::scheme($options[Arg::SCHEME] ?? ''),
            static::authority(
                $options[Arg::HOST] ?? '', $options[Arg::PORT] ?? null,
                    $options[Arg::USER] ?? '', $options[Arg::PASS] ?? ''
            ),
            static::path($path),
            static::query($query),
            static::fragment($fragment)
        );
    }

    /**
     * @param string $user
     * @param string $password
     * @param string $suffix
     * @return string
     */
    static function user($user, $password = '', $suffix = '')
    {
        return $user ? static::encode($user . ($password ? ':' . $password : '')) . $suffix  : '';
    }

    /**
     * @param string|Uri $path
     * @param string $query
     * @param string $fragment
     * @param array $options
     * @return string
     */
    function __invoke($path, $query = '', $fragment = '', array $options = [])
    {
        return $path instanceof Uri ? static::uri($path) : static::url($path, $query, $fragment, $options);
    }
}
