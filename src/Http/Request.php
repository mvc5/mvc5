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
     * @return array|Headers
     */
    function headers();

    /**
     * @return string
     */
    function method();

    /**
     * @return string|Uri
     */
    function uri();

    /**
     * @return int
     */
    function version();
}
