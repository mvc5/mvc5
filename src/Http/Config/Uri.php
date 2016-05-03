<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\Arg;
use Mvc5\Config\Config;

trait Uri
{
    /**
     *
     */
    use Config;

    /**
     * @return string
     */
    function fragment()
    {
        return $this[Arg::FRAGMENT];
    }

    /**
     * @return string
     */
    function host()
    {
        return $this[Arg::HOST];
    }

    /**
     * @return string
     */
    function method()
    {
        return $this[Arg::METHOD];
    }

    /**
     * @return string
     */
    function path()
    {
        return $this[Arg::PATH];
    }

    /**
     * @return string
     */
    function query()
    {
        return $this[Arg::QUERY];
    }

    /**
     * @return string
     */
    function password()
    {
        return $this[Arg::PASS];
    }

    /**
     * @return int
     */
    function port()
    {
        return $this[Arg::PORT];
    }

    /**
     * @return string
     */
    function scheme()
    {
        return $this[Arg::SCHEME];
    }

    /**
     * @return string
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
