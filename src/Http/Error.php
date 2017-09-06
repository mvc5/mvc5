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
     * @return int|null
     */
    function code();

    /**
     * @return string|null
     */
    function description();

    /**
     * @return array
     */
    function errors() : array;

    /**
     * @return string|null
     */
    function message();

    /**
     * @return int|null
     */
    function status();
}
