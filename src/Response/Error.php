<?php
/**
 *
 */

namespace Mvc5\Response;

use Mvc5\Config\Configuration;

interface Error
    extends Configuration
{
    /**
     * @return int
     */
    function code();

    /**
     * @return int
     */
    function description();

    /**
     * @return array
     */
    function errors();

    /**
     * @return string
     */
    function message();

    /**
     * @return int
     */
    function status();
}
