<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

interface Child
    extends Plugin
{
    /**
     * @return string|mixed
     */
    function parent();
}
