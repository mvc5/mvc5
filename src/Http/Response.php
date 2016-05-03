<?php
/**
 *
 */

namespace Mvc5\Http;

use Mvc5\Config\Configuration;

interface Response
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
    function reason();

    /**
     * @return int
     */
    function status();

    /**
     * @return int
     */
    function version();
}
