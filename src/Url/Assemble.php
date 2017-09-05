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
     * @param string|null $host
     * @param int|null $port
     * @param string|null $user
     * @param string|null $password
     * @return string
     */
    static function authority(string $host = null, int $port = null, string $user = null, string $password = null) : string
    {
        return static::user($user, $password, '@') . static::host($host) . static::port($port, ':');
    }

    /**
     * @param string|null $scheme
     * @param string|null $authority
     * @param string|null $path
     * @param string|null $query
     * @param string|null $fragment
     * @return string
     */
    static function compile(string $scheme = null, string $authority = null, string $path = null, string $query = null, string $fragment = null) : string
    {
        return ($scheme ? $scheme . ':' : '') . ($scheme || $authority ? '//' : '') . $authority .
            $path . ($query ? '?' . $query : '') . ($fragment ? '#' . $fragment : '');
    }

    /**
     * @param string|null $value
     * @param array $unreserved
     * @return string|null
     */
    static function encode(string $value = null, array $unreserved = [])
    {
        return $value ? strtr(rawurlencode($value), $unreserved ?: static::UNRESERVED) : $value;
    }

    /**
     * @param string|null $fragment
     * @return string|null
     */
    static function fragment(string $fragment = null)
    {
        return static::encode($fragment, static::FRAGMENT);
    }

    /**
     * @param string|null $host
     * @return string|null
     */
    static function host(string $host = null)
    {
        return static::encode(strtolower((string) $host));
    }

    /**
     * @param string|null $path
     * @return string|null
     */
    static function path(string $path = null)
    {
        return static::encode($path, static::PATH);
    }

    /**
     * @param int|null $port
     * @param string|null $prefix
     * @return string|null
     */
    static function port(int $port = null, string $prefix = null)
    {
        return $port && 80 != $port && 443 != $port ? $prefix . $port : null;
    }

    /**
     * @param array|string|null $query
     * @return string|null
     */
    static function query($query)
    {
        return is_array($query) ? strtr(
            http_build_query($query, '', Arg::QUERY_SEPARATOR, \PHP_QUERY_RFC3986), static::QUERY
        ) : static::encode($query, static::QUERY_STRING);
    }

    /**
     * @param string|null $scheme
     * @return string|null
     */
    static function scheme(string $scheme = null)
    {
        return $scheme ? strtolower($scheme) : $scheme;
    }

    /**
     * @param string|Uri|null $path
     * @param array|string|null $query
     * @return string
     */
    static function target($path = null, $query = null) : string
    {
        return $path instanceof Uri ? static::url($path->path() ?: '/', $path->query()) :
            static::url($path ?: '/', $query);
    }

    /**
     * @param Uri $uri
     * @return string
     */
    static function uri(Uri $uri) : string
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
     * @param array|string|null $query
     * @param string|null $fragment
     * @param array $options
     * @return string
     */
    static function url(string $path, $query = null, string $fragment = null, array $options = []) : string
    {
        return static::compile(
            static::scheme($options[Arg::SCHEME] ?? null),
            static::authority(
                $options[Arg::HOST] ?? null, $options[Arg::PORT] ?? null,
                    $options[Arg::USER] ?? null, $options[Arg::PASS] ?? null
            ),
            static::path($path),
            static::query($query),
            static::fragment($fragment)
        );
    }

    /**
     * @param string|null $user
     * @param string|null $password
     * @param string|null $suffix
     * @return string|null
     */
    static function user(string $user = null, string $password = null, string $suffix = null)
    {
        return $user ? static::encode($user . ($password ? ':' . $password : '')) . $suffix : $user;
    }

    /**
     * @param string|Uri $path
     * @param array|string|null $query
     * @param string|null $fragment
     * @param array $options
     * @return string
     */
    function __invoke($path, $query = null, string $fragment = null, array $options = []) : string
    {
        return $path instanceof Uri ? static::uri($path) : static::url($path, $query, $fragment, $options);
    }
}
