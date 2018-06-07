<?php
/**
 *
 */

namespace Mvc5\Http;

use Mvc5\Config\Model;

interface Request
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
    function method() : ?string;

    /**
     * @return string|Uri|null
     */
    function uri();

    /**
     * @return string|null
     */
    function version() : ?string;
}
