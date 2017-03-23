<?php
/**
 *
 */

namespace Mvc5\Http;

use Mvc5\Config\Immutable;

interface Uri
    extends Immutable
{
    /**
     * @return string
     */
    function fragment();

    /**
     * @return string
     */
    function host();

    /**
     * @return string
     */
    function password();

    /**
     * @return string
     */
    function path();

    /**
     * @return int
     */
    function port();

    /**
     * @return string
     */
    function query();

    /**
     * @return string
     */
    function scheme();

    /**
     * @return string
     */
    function user();

    /**
     * @return string
     */
    function __toString();
}
