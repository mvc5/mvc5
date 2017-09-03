<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\Arg;
use Mvc5\Url;

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
        /** @var \Mvc5\Http\Uri $this */
        return Url\Assemble::uri($this);
    }
}
