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
        !isset($config[Arg::HEADERS]) &&
            $config[Arg::HEADERS] = new Http\HttpHeaders;

        is_array($config[Arg::HEADERS]) &&
            $config[Arg::HEADERS] = new Http\HttpHeaders($config[Arg::HEADERS]);

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
     * @return string|Http\Uri|null
     */
    function uri()
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
