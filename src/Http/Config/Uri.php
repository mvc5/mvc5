<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\ArrayObject;
use Mvc5\Config\Model;

use function implode;
use function is_array;
use function parse_url;

use const Mvc5\{ FRAGMENT, HOST, PASS, PATH, PORT, QUERY, SCHEME, USER };

trait Uri
{
    /**
     * @var Model
     */
    protected Model $config;

    /**
     * @param array|string|mixed $config
     */
    function __construct($config = [])
    {
        $this->config = $config instanceof Model ? $config : new ArrayObject(
            is_array($config) ? $config : (parse_url((string) $config) ?: []));
    }

    /**
     * @return string|null
     */
    function fragment() : ?string
    {
        return $this[FRAGMENT];
    }

    /**
     * @return string|null
     */
    function host() : ?string
    {
        return $this[HOST];
    }

    /**
     * @return string|null
     */
    function password() : ?string
    {
        return $this[PASS];
    }

    /**
     * @return string|null
     */
    function path() : ?string
    {
        return $this[PATH];
    }

    /**
     * @return int|null
     */
    function port() : ?int
    {
        return $this[PORT];
    }

    /**
     * @return array|string|null
     */
    function query()
    {
        return $this[QUERY];
    }

    /**
     * @return string|null
     */
    function scheme() : ?string
    {
        return $this[SCHEME];
    }

    /**
     * @return string|null
     */
    function user() : ?string
    {
        return $this[USER];
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
