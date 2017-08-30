<?php
/**
 *
 */

namespace Mvc5\Http;

use Mvc5\Config\Model;

interface Error
    extends Model
{
    /**
     * @return int
     */
    function code();

    /**
     * @return string
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
