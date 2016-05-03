<?php
/**
 *
 */

namespace Mvc5\Http;

use Mvc5\Config\Configuration;

interface Request
    extends Configuration
{
    /**
     * @return mixed
     */
    function body();

    /**
     * @return array|Configuration
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
