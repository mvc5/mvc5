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
     * @param string $scheme
     * @param string $host
     * @param int $port
     * @param string $path
     * @param string $query
     * @param string $fragment
     * @return string
     */
    static function build($scheme, $host, $port, $path, $query, $fragment)
    {
        return static::component($scheme, $host && $port ? $host . ':' . $port : $host, $path, $query, $fragment);
    }

    /**
     * @param string $scheme
     * @param string $authority
     * @param string $path
     * @param string $query
     * @param string $fragment
     * @return string
     */
    static function component($scheme, $authority, $path, $query, $fragment)
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
        return strtolower($host);
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
     * @return int|null
     */
    static function port($port)
    {
        return $port && 80 != $port && 443 != $port ? (int) $port : null;
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
     * @param string $scheme
     * @param string $host
     * @param int $port
     * @param string $path
     * @param array|string $query
     * @param null|string $fragment
     * @return string
     */
    static function url($scheme, $host, $port, $path, $query = '', $fragment = '')
    {
        return static::build(
            static::scheme($scheme), static::host($host), static::port($port),
                static::path($path), static::query($query), static::fragment($fragment)
        );
    }

    /**
     * @param Uri $uri
     * @return string
     */
    function __invoke(Uri $uri)
    {
        return static::url($uri->scheme(), $uri->host(), $uri->port(), $uri->path(), $uri->query(), $uri->fragment());
    }
}
