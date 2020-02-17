<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\Arg;
use Mvc5\Http;

trait Request
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @param array $config
     */
    function __construct($config = [])
    {
        $config[Arg::HEADERS] ??= new Http\HttpHeaders;

        is_array($config[Arg::HEADERS]) &&
            $config[Arg::HEADERS] = new Http\HttpHeaders($config[Arg::HEADERS]);

        isset($config[Arg::URI]) && !($config[Arg::URI] instanceof Http\Uri) &&
            $config[Arg::URI] = new Http\HttpUri($config[Arg::URI]);

        $this->config = $config;
    }

    /**
     * @return mixed
     */
    function body()
    {
        return $this[Arg::BODY];
    }

    /**
     * @return Http\Headers
     */
    function headers() : Http\Headers
    {
        return $this[Arg::HEADERS];
    }

    /**
     * @return string|null
     */
    function method() : ?string
    {
        return $this[Arg::METHOD];
    }

    /**
     * @return Http\Uri|null
     */
    function uri() : ?Http\Uri
    {
        return $this[Arg::URI];
    }

    /**
     * @return string|null
     */
    function version() : ?string
    {
        return $this[Arg::VERSION];
    }
}
