<?php
/**
 *
 */

namespace Mvc5\Route;

use Mvc5\Config\Model;

interface Route
    extends Model
{
    /**
     * @param string|null $name
     * @return callable|mixed
     */
    function action(string $name = null);

    /**
     * @param string $name
     * @return array|Route|null
     */
    function child(string $name);

    /**
     * @return array|\Iterator
     */
    function children();

    /**
     * @return array
     */
    function constraints() : array;

    /**
     * @return callable|mixed
     */
    function controller();

    /**
     * @return array
     */
    function defaults() : array;

    /**
     * @return array|string|null
     */
    function host();

    /**
     * @return array|string|null
     */
    function method();

    /**
     * @return string|null
     */
    function name() : ?string;

    /**
     * @return array
     */
    function options() : array;

    /**
     * @return array|string|null
     */
    function path();

    /**
     * @return int|null
     */
    function port() : ?int;

    /**
     * @return string|null
     */
    function regex() : ?string;

    /**
     * @return array|string|null
     */
    function scheme();

    /**
     * @return array
     */
    function tokens() : array;

    /**
     * @return bool
     */
    function wildcard() : bool;
}
