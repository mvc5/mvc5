<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

interface Dependency
    extends Gem
{
    /**
     * @return string
     */
    function name();

    /**
     * @return string
     */
    function config();
}
