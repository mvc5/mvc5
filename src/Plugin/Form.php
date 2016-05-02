<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Arg;

class Form
    extends Child
{
    /**
     * @param string $name
     */
    function __construct($name)
    {
        parent::__construct($name, Arg::FORM);
    }
}
