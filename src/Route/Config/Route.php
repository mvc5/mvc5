<?php
/**
 *
 */

namespace Mvc5\Route\Config;

use Mvc5\Arg;

trait Route
{
    /**
     * @param string|null $name
     * @return callable|mixed
     */
    function action(string $name = null)
    {
        return null === $name ? $this[Arg::ACTION] : ($this->get(Arg::ACTION)[$name] ?? null);
    }

    /**
     * @param string $name
     * @return array|\Mvc5\Route\Route|null
     */
    function child(string $name)
    {
        return $this->get(Arg::CHILDREN)[$name] ?? null;
    }

    /**
     * @return array|\Iterator
     */
    function children()
    {
        return $this[Arg::CHILDREN] ?? [];
    }

    /**
     * @return array
     */
    function constraints() : array
    {
        return $this[Arg::CONSTRAINTS] ?? [];
    }

    /**
     * @return callable|mixed
     */
    function controller()
    {
        return $this[Arg::CONTROLLER];
    }

    /**
     * @return array
     */
    function defaults() : array
    {
        return $this[Arg::DEFAULTS] ?? [];
    }

    /**
     * @return array|string|null
     */
    function host()
    {
        return $this[Arg::HOST];
    }

    /**
     * @return array|string|null
     */
    function method()
    {
        return $this[Arg::METHOD];
    }

    /**
     * @return string|null
     */
    function name()
    {
        return $this[Arg::NAME];
    }

    /**
     * @return array
     */
    function options() : array
    {
        return $this[Arg::OPTIONS] ?? [];
    }

    /**
     * @return array|string|null
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
     * @return string|null
     */
    function regex()
    {
        return $this[Arg::REGEX];
    }

    /**
     * @return array|string|null
     */
    function scheme()
    {
        return $this[Arg::SCHEME];
    }

    /**
     * @return array
     */
    function tokens() : array
    {
        return $this[Arg::TOKENS] ?? [];
    }

    /**
     * @return bool
     */
    function wildcard() : bool
    {
        return (bool) $this[Arg::WILDCARD];
    }
}
