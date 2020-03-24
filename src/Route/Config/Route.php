<?php
/**
 *
 */

namespace Mvc5\Route\Config;

use const Mvc5\{ ACTION, CHILDREN, CONSTRAINTS, CONTROLLER, DEFAULTS,
    HOST, METHOD, NAME, OPTIONS, PATH, PORT, REGEX, SCHEME, TOKENS, WILDCARD };

trait Route
{
    /**
     * @param string $name
     * @return callable|mixed
     */
    function action(string $name)
    {
        return $this->get(ACTION)[$name] ?? null;
    }

    /**
     * @param string $name
     * @return array|\Mvc5\Route\Route|null
     */
    function child(string $name)
    {
        return $this->get(CHILDREN)[$name] ?? null;
    }

    /**
     * @return iterable
     */
    function children() : iterable
    {
        return $this[CHILDREN] ?? [];
    }

    /**
     * @return array
     */
    function constraints() : array
    {
        return $this[CONSTRAINTS] ?? [];
    }

    /**
     * @return callable|mixed
     */
    function controller()
    {
        return $this[CONTROLLER];
    }

    /**
     * @return array
     */
    function defaults() : array
    {
        return $this[DEFAULTS] ?? [];
    }

    /**
     * @return array|string|null
     */
    function host()
    {
        return $this[HOST];
    }

    /**
     * @return array|string|null
     */
    function method()
    {
        return $this[METHOD];
    }

    /**
     * @return string|null
     */
    function name() : ?string
    {
        return $this[NAME];
    }

    /**
     * @return array
     */
    function options() : array
    {
        return $this[OPTIONS] ?? [];
    }

    /**
     * @return array|string|null
     */
    function path()
    {
        return $this[PATH];
    }

    /**
     * @return int|null
     */
    function port() : ?int
    {
        return $this[PORT];
    }

    /**
     * @return string|null
     */
    function regex() : ?string
    {
        return $this[REGEX];
    }

    /**
     * @return array|string|null
     */
    function scheme()
    {
        return $this[SCHEME];
    }

    /**
     * @return array
     */
    function tokens() : array
    {
        return $this[TOKENS] ?? [];
    }

    /**
     * @return bool
     */
    function wildcard() : bool
    {
        return (bool) $this[WILDCARD];
    }
}
