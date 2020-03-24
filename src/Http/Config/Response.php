<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\ArrayObject;
use Mvc5\Http;
use Mvc5\Config\Model;

use function is_array;

use const Mvc5\{ BODY, HEADERS, REASON, STATUS, VERSION };

trait Response
{
    /**
     * @var Model
     */
    protected Model $config;

    /**
     * @param array|Model $config
     */
    function __construct($config = [])
    {
        $config[HEADERS] ??= new Http\HttpHeaders;

        is_array($config[HEADERS]) &&
            $config[HEADERS] = new Http\HttpHeaders($config[HEADERS]);

        $this->config = $config instanceof Model ? $config: new ArrayObject((array) $config);
    }

    /**
     * @return mixed
     */
    function body()
    {
        return $this[BODY];
    }

    /**
     * @return Http\Headers
     */
    function headers() : Http\Headers
    {
        return $this[HEADERS];
    }

    /**
     * @return string|null
     */
    function reason() : ?string
    {
        return $this[REASON];
    }

    /**
     * @return int|null
     */
    function status() : ?int
    {
        return $this[STATUS];
    }

    /**
     * @return string|null
     */
    function version() : ?string
    {
        return $this[VERSION];
    }
}
