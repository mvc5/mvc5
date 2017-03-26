<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\Arg;
use Mvc5\Config\ReadOnly;

trait Uri
{
    /**
     *
     */
    use ReadOnly;

    /**
     * @param array|string $config
     */
    function __construct($config = [])
    {
        $this->config = is_string($config) ? parse_url($config) : $config;
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
     * @return string
     */
    function query()
    {
        return (string) $this[Arg::QUERY];
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
        $query    = ltrim($this->query(), '?');
        $fragment = $this->fragment();

        $path .= ($query ? '?'. $query : '') . ($fragment ? '#' . $fragment : '');

        $user = $this->user() ? ($this->user() . ':' . $this->password()) : '';

        $scheme = $this->scheme();
        $host   = $this->host();
        $port   = $this->port();

        ($port == 80 || $port == 443) &&
            $port = null;

        return ($scheme ? $scheme . ':' : '') . '//' .
            ($user ? $user . '@' : '') . $host . ($port ? ':' . $port : '') . '/' . ltrim($path, '/');
    }
}
