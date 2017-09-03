<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\Arg;

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
    function fragment()
    {
        return $this[Arg::FRAGMENT];
    }

    /**
     * @return string|null
     */
    function host()
    {
        return $this[Arg::HOST];
    }

    /**
     * @return string|null
     */
    function password()
    {
        return $this[Arg::PASS];
    }

    /**
     * @return string|null
     */
    function path()
    {
        return $this[Arg::PATH];
    }

    /**
     * @return int|null
     */
    function port()
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
    function scheme()
    {
        return $this[Arg::SCHEME];
    }

    /**
     * @return string|null
     */
    function user()
    {
        return $this[Arg::USER];
    }

    /**
     * @return string
     */
    function __toString()
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
                $path . ($query ? '?'. $query : '') . ($fragment ? '#' . $fragment : '');
    }
}
