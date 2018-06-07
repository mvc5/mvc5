<?php
/**
 *
 */

namespace Mvc5\Http;

use Mvc5\Config\Model;

interface Headers
    extends Model
{
    /**
     * @return array
     */
    function all() : array;

    /**
     * @param string|string[] $name
     * @return string|string[]
     */
    function header($name);
}
