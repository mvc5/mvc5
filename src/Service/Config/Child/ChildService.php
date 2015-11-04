<?php
/**
 *
 */

namespace Mvc5\Service\Config\Child;

use Mvc5\Service\Config\Configuration;

interface ChildService
    extends Configuration
{
    /**
     *
     */
    const PARENT = 'parent';

    /**
     * @return string
     */
    function parent();
}
