<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\Arg;
use Mvc5\Http;

use function is_array;

trait Response
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
    function reason() : ?string
    {
        return $this[Arg::REASON];
    }

    /**
     * @return int|null
     */
    function status() : ?int
    {
        return $this[Arg::STATUS];
    }

    /**
     * @return string|null
     */
    function version() : ?string
    {
        return $this[Arg::VERSION];
    }
}
