<?php
/**
 *
 */

namespace Mvc5\Plugin;

use const Mvc5\FORM;

class Form
    extends Child
{
    /**
     * @param string $name
     */
    function __construct(string $name)
    {
        parent::__construct($name, FORM);
    }
}
