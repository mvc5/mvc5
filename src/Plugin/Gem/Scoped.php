<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

interface Scoped
    extends Gem
{
    /**
     * @return \Closure
     */
    function closure();
}
