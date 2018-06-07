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
     * @return Uri|null
     */
    function uri() : ?Uri;

    /**
     * @return string|null
     */
    function version() : ?string;
}
