<?php
/**
 *
 */

namespace Mvc5\Url;

use Mvc5\Arg;

/**
 * Portions copyright (c) 2013 Ben Scholzen 'DASPRiD'. (http://github.com/DASPRiD/Dash)
 * under the Simplified BSD License (http://opensource.org/licenses/BSD-2-Clause).
 */
class Assemble
{
    /**
     * @var array
     */
    protected static $allowedPathChars = [
        '%2F' => '/',
        '%40' => '@',
        '%3A' => ':',
        '%3B' => ';',
        '%2C' => ',',
        '%3D' => '=',
        '%2B' => '+',
        '%21' => '!',
        '%2A' => '*',
        '%7C' => '|',
    ];

    /**
     * @param null|string $scheme
     * @param null|string $host
     * @param null|string $port
     * @param null|string $path
     * @param array|\ArrayAccess $options
     * @return string
     */
    function __invoke($scheme, $host, $port, $path, $options)
    {
        $path = strtr(rawurlencode($path), static::$allowedPathChars);

        !empty($options[Arg::QUERY]) &&
            $path .= '?' . http_build_query($options[Arg::QUERY], '', '&');

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
