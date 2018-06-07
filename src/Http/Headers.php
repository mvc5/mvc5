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
}
