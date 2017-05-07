<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\Arg;

trait Uri
{
    /**
     * @param array|string|mixed $config
     */
    function __construct($config = [])
    {
        $this->config = is_array($config) ? $config : parse_url((string) $config);
    }

    /**
     * @return string
     */
    function fragment()
    {
        return (string) $this[Arg::FRAGMENT];
    }

    /**
     * @return string
     */
    function host()
    {
        return (string) $this[Arg::HOST];
    }

    /**
     * @return null|string
     */
    function password()
    {
        return $this[Arg::PASS];
    }

    /**
     * @return string
     */
    function path()
    {
        return (string) $this[Arg::PATH];
    }

    /**
     * @return int|null
     */
    function port()
    {
        return $this[Arg::PORT];
    }

    /**
     * @return array|string
     */
    function query()
    {
        return $this[Arg::QUERY];
    }

    /**
     * @return string
     */
    function scheme()
    {
        return (string) $this[Arg::SCHEME];
    }

    /**
     * @return mixed|string
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
        $path     = $this->path();
        $query    = $this->query();
        $fragment = $this->fragment();

        $user = $this->user() ? $this->user() . ($this->password() ? ':' . $this->password() : '') : '';

        $scheme = $this->scheme();
        $host   = $this->host();
        $port   = $this->port();

        ($port == 80 || $port == 443) &&
            $port = null;

        return ($scheme ? $scheme . ':' : '') . ($scheme || $host ? '//' : '') .
            ($host ? ($user ? $user . '@' : '') . $host . ($port ? ':' . $port : '') : '') .
                $path . ($query ? '?'. $query : '') . ($fragment ? '#' . $fragment : '');
    }
}
