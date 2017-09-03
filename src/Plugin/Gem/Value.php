<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

interface Value
    extends Gem
{
    /**
     * @return string|mixed
     */
    function config();
}
