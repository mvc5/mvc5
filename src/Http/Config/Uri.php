<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\Arg;

use function implode;
use function is_array;
use function parse_url;

trait Uri
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @param array|string|mixed $config
     */
    function __construct($config = [])
    {
        $this->config = is_array($config) ? $config : (parse_url((string) $config) ?: []);
    }

    /**
     * @return string|null
     */
    function fragment() : ?string
    {
        return $this[Arg::FRAGMENT];
    }

    /**
     * @return string|null
     */
    function host() : ?string
    {
        return $this[Arg::HOST];
    }

    /**
     * @return string|null
     */
    function password() : ?string
    {
        return $this[Arg::PASS];
    }

    /**
     * @return string|null
     */
    function path() : ?string
    {
        return $this[Arg::PATH];
    }

    /**
     * @return int|null
     */
    function port() : ?int
    {
        return $this[Arg::PORT];
    }

    /**
     * @return array|string|null
     */
    function query()
    {
        return $this[Arg::QUERY];
    }

    /**
     * @return string|null
     */
    function scheme() : ?string
    {
        return $this[Arg::SCHEME];
    }

    /**
     * @return string|null
     */
    function user() : ?string
    {
        return $this[Arg::USER];
    }

    /**
     * @return string
     */
    function __toString() : string
    {
        $path = $this->path();
        $query = $this->query();
        $fragment = $this->fragment();

        $user = $this->user() ? $this->user() . ($this->password() ? ':' . $this->password() : '') : '';

        $scheme = $this->scheme();
        $host = $this->host();
        $port = $this->port();

        ($port == 80 || $port == 443) &&
            $port = null;

        return ($scheme ? $scheme . ':' : '') . ($scheme || $host ? '//' : '') .
            ($host ? ($user ? $user . '@' : '') . $host . ($port ? ':' . $port : '') : '') .
                $path . ($query ? '?'. (is_array($query) ? query($query) : $query) : '') . ($fragment ? '#' . $fragment : '');
    }
}

/**
 * @param array $query
 * @param string $parent
 * @param array $args
 * @return string
 */
function query(array $query, string $parent = '', array $args = []) : string
{
    foreach($query as $key => $value) {
        $key = $parent ? $parent . '[' . $key . ']' : $key;
        $args[] = is_array($value) ? query($value, $key) : (isset($value) ? $key . '=' . $value : $key);
    }

    return implode('&', $args);
}
