<?php
/**
 *
 */

namespace Mvc5\Route\Config;

use Mvc5\Arg;
use Mvc5\Config\Config;
use Mvc5\Response\Error;

trait Route
{
    /**
     *
     */
    use Config;

    /**
     * @return array|callable|null|object|string
     */
    function controller()
    {
        return $this[Arg::CONTROLLER];
    }

    /**
     * @return Error
     */
    function error()
    {
        return $this[Arg::ERROR];
    }

    /**
     * @return string|string[]
     */
    function hostname()
    {
        return $this[Arg::HOSTNAME];
    }

    /**
     * @return int
     */
    function length()
    {
        return $this[Arg::LENGTH] ?? 0;
    }

    /**
     * @return bool
     */
    function matched()
    {
        return $this[Arg::MATCHED] ?? false;
    }

    /**
     * @return string|string[]
     */
    function method()
    {
        return $this[Arg::METHOD];
    }

    /**
     * @return string
     */
    function name()
    {
        return $this[Arg::NAME];
    }

    /**
     * @param $name
     * @return mixed
     */
    function param($name)
    {
        return $this[Arg::PARAMS][$name] ?? null;
    }

    /**
     * @return array
     */
    function params()
    {
        return $this[Arg::PARAMS] ?? [];
    }

    /**
     * @return string
     */
    function path()
    {
        return $this[Arg::PATH];
    }

    /**
     * @return int|null|string
     */
    function port()
    {
        return $this[Arg::PORT];
    }

    /**
     * @return string|string[]
     */
    function scheme()
    {
        return $this[Arg::SCHEME];
    }
}
