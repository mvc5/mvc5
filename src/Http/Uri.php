<?php
/**
 *
 */

namespace Mvc5\Http;

use Mvc5\Config\Model;

interface Uri
    extends Model
{
    /**
     * @return string|null
     */
    function fragment();

    /**
     * @return string|null
     */
    function host();

    /**
     * @return string|null
     */
    function password();

    /**
     * @return string|null
     */
    function path();

    /**
     * @return int|null
     */
    function port();

    /**
     * @return array|string|null
     */
    function query();

    /**
     * @return string|null
     */
    function scheme();

    /**
     * @return string|null
     */
    function user();

    /**
     * @return string
     */
    function __toString() : string;
}
