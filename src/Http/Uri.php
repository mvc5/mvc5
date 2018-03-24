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
    function fragment() : ?string;

    /**
     * @return string|null
     */
    function host() : ?string;

    /**
     * @return string|null
     */
    function password() : ?string;

    /**
     * @return string|null
     */
    function path() : ?string;

    /**
     * @return int|null
     */
    function port() : ?int;

    /**
     * @return array|string|null
     */
    function query();

    /**
     * @return string|null
     */
    function scheme() : ?string;

    /**
     * @return string|null
     */
    function user() : ?string;

    /**
     * @return string
     */
    function __toString() : string;
}
