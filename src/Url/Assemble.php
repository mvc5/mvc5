<?php
/**
 *
 */

namespace Mvc5\Url;

use Mvc5\Arg;

class Assemble
{
    /**
     * @param array $query
     * @param string $parent
     * @param array $params
     * @return string
     */
    static function buildQuery(array $query, $parent = '', $params = [])
    {
        foreach($query as $key => $value) {
            $key = $parent ? $parent . '[' . static::encode($key) . ']' : static::encode($key);
            $params[] = is_array($value) ? static::buildQuery($value, $key) :
                (!isset($value) ? $key : $key . '=' . static::encode($value));
        }

        return implode('&', $params);
    }

    /**
     * @param $value
     * @return mixed
     */
    static function encode($value)
    {
        return preg_replace_callback(
            '/(?:[^a-zA-Z0-9_\-\.~!\$&\'\(\)\*\+,;=%:@\/\?]++|%(?![A-Fa-f0-9]{2}))/',
            function(array $match) { return \rawurlencode($match[0]); },
            $value
        );
    }

    /**
     * @param null|string $scheme
     * @param null|string $host
     * @param null|string $port
     * @param null|string $path
     * @param array|\ArrayAccess $options
     * @return string
     */
    static function url($scheme, $host, $port, $path, $options = [])
    {
        $path = static::encode($path);

        !empty($options[Arg::QUERY]) &&
            $path .= '?' . static::buildQuery($options[Arg::QUERY]);

        isset($options[Arg::FRAGMENT]) &&
            $path .= '#' . $options[Arg::FRAGMENT];

        $canonical = !empty($options[Arg::CANONICAL]);

        !$port && $port = $options[Arg::PORT];

        ($port == 80 || $port == 443) &&
            $port = null;

        $scheme = $scheme ? (!$port && !$canonical && $scheme === $options[Arg::SCHEME] ? '' : $scheme) :
            ($canonical || $port ? $options[Arg::SCHEME] : '');

        $host = $host ? (!$scheme && !$canonical && $host === $options[Arg::HOST] ? '' : $host) :
            ($canonical || $scheme ? $options[Arg::HOST] : '');

        return ($scheme ? $scheme . ':' : '') . ($host ? '//' . $host : '') . ($port ? ':' . $port : '') . $path;
    }
}
