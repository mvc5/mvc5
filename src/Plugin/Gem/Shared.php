<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

interface Shared
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
