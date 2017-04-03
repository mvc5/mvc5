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
    protected static $path = [
        '%21' => '!', '%24' => '$', '%26' => '&', '%27' => '\'', '%28' => '(', '%29' => ')', '%2A' => '*',
        '%2B' => '+', '%2C' => ',', '%3B' => ';', '%3D' => '=', '%3A' => ':', '%40' => '@', '%2F' => '/'
    ];

    /**
     * @var string
     */
    protected static $separator = Arg::QUERY_SEPARATOR;

    /**
     * @var int
     */
    protected static $type = \PHP_QUERY_RFC3986;

    /**
     *
     */
    protected static $var = ['%21' => '!', '%2A' => '*', '%27' => '\'', '%28' => '(', '%29' => ')'];

    /**
     * @param array $options
     */
    function __construct(array $options = [])
    {
        isset($options[Arg::SEPARATORS]) &&
            (static::$separator = $options[Arg::SEPARATORS][0]);

        isset($options[Arg::TYPE]) &&
            (static::$type = $options[Arg::TYPE]);

        isset($options[Arg::VALUE]) &&
            (static::$var = $options[Arg::VALUE]);
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
    static function assemble($scheme, $host, $port, $path, $query, $fragment)
    {
        return ($scheme ? $scheme . ':' : '') . ($host ? '//' . $host : '') . ($host && $port ? ':' . $port : '') .
            $path . ($query ? '?' . $query : '') . ($fragment ? '#' . $fragment : '');
    }

    /**
     * @param string $value
     * @param array $unreserved
     * @return string
     */
    static function encode($value, array $unreserved = [])
    {
        return $value ? strtr(rawurlencode($value), $unreserved ?: static::$var) : '';
    }

    /**
     * @param string $value
     * @return string
     */
    static function fragment($value)
    {
        return static::encode($value);
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
        return http_build_query(
            is_string($query) ? explode(static::$separator, $query) : $query, '', static::$separator, static::$type
        );
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
        return static::assemble(
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
