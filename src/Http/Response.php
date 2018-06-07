<?php
/**
 *
 */

namespace Mvc5\Http;

use Mvc5\Config\Model;

interface Response
    extends Model
{
    /**
     * @return mixed
     */
    function body();

    /**
     * @return Headers
     */
    function headers() : Headers;

    /**
     * @return string|null
     */
    function reason() : ?string;

    /**
     * @return int|null
     */
    function status() : ?int;

    /**
     * @return string|null
     */
    function version() : ?string;
}
