<?php
/**
 *
 */

namespace Mvc5\Url;

use Mvc5\Arg;

class Assemble
{
    /**
     *
     */
    const FRAGMENT = self::UNRESERVED + ['%2B' => '+', '%26' => '&', '%3F' => '?'];

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
    const UNRESERVED = [
        '%2F' => '/', '%5B' => '[', '%5D' => ']', '%3A' => ':', '%40' => '@', '%21' => '!', '%24' => '$',
        '%27' => "'", '%28' => '(', '%29' => ')', '%2A' => '*', '%2C' => ',', '%3B' => ';', '%3D' => '='
    ];

    /**
     * @var array
     */
    protected static $fragment = self::FRAGMENT;

    /**
     * @var array
     */
    protected static $path = self::PATH;

    /**
     * @var array
     */
    protected static $query = self::QUERY;

    /**
     * @var string
     */
    protected static $separator = Arg::QUERY_SEPARATOR;

    /**
     * @var int
     */
    protected static $type = \PHP_QUERY_RFC3986;

    /**
     * @param array $options
     */
    function __construct(array $options = [])
    {
        isset($options[Arg::FRAGMENT]) &&
            (static::$fragment = $options[Arg::FRAGMENT]);

        isset($options[Arg::PATH]) &&
            (static::$path = $options[Arg::PATH]);

        isset($options[Arg::QUERY]) &&
            (static::$query = $options[Arg::QUERY]);

        isset($options[Arg::SEPARATORS]) &&
            (static::$separator = $options[Arg::SEPARATORS][0]);

        isset($options[Arg::TYPE]) &&
            (static::$type = $options[Arg::TYPE]);
    }

    /**
     * @param null|string $scheme
     * @param null|string $host
     * @param null|string $port
     * @param null|string $path
     * @param array|string $query
     * @param null|string $fragment
     * @return string
     */
    static function build($scheme, $host, $port, $path, $query, $fragment)
    {
        return static::component($scheme, $host && $port ? $host . ':' . $port : $host, $path, $query, $fragment);
    }

    /**
     * @param null|string $scheme
     * @param null|string $authority
     * @param null|string $path
     * @param array|string $query
     * @param null|string $fragment
     * @return string
     */
    static function component($scheme, $authority, $path, $query, $fragment)
    {
        return ($scheme ? $scheme . ':' : '') . ($authority ? '//' . $authority : '') .
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
        return static::encode($value, static::$fragment);
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
        return static::encode($path, static::$path);
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
        return strtr(http_build_query(
            is_string($query) ? explode(static::$separator, $query) : $query, '', static::$separator, static::$type
        ), static::$query);
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
     * @param null|string $path
     * @param array|string $query
     * @param null|string $fragment
     * @param null|string $host
     * @param null|string $scheme
     * @param null|string $port
     * @return string
     */
    static function url($path, $query = [], $fragment = null, $host = null, $scheme = null, $port = null)
    {
        return static::build(
            static::scheme($scheme), static::host($host), static::port($port),
                static::path($path), static::query($query), static::fragment($fragment)
        );
    }

    /**
     * @param $scheme
     * @param $host
     * @param $port
     * @param $path
     * @param array $options
     * @return string
     */
    function __invoke($scheme, $host, $port, $path, array $options = [])
    {
        $canonical = !empty($options[Arg::CANONICAL]);

        !$port && $port = $options[Arg::PORT] ?? null;

        ($port == 80 || $port == 443) &&
            $port = null;

        $scheme = $scheme ? (!$port && !$canonical && $scheme === $options[Arg::SCHEME] ? '' : $scheme) :
            ($canonical || $port ? $options[Arg::SCHEME] : '');

        $host = $host ? (!$scheme && !$canonical && $host === $options[Arg::HOST] ? '' : $host) :
            ($canonical || $scheme ? $options[Arg::HOST] : '');

        return static::url($path, $options[Arg::QUERY] ?? [], $options[Arg::FRAGMENT] ?? null, $host, $scheme, $port);
    }
}
