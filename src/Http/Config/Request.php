<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\ArrayObject;
use Mvc5\Config\Model;
use Mvc5\Http;

use const Mvc5\{ BODY, HEADERS, METHOD, URI, VERSION };

trait Request
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

        isset($config[URI]) && !($config[URI] instanceof Http\Uri) &&
            $config[URI] = new Http\HttpUri($config[URI]);

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
    function method() : ?string
    {
        return $this[METHOD];
    }

    /**
     * @return Http\Uri|null
     */
    function uri() : ?Http\Uri
    {
        return $this[URI];
    }

    /**
     * @return string|null
     */
    function version() : ?string
    {
        return $this[VERSION];
    }
}
