<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

interface Call
    extends Gem
{
    /**
     * @return array
     */
    function args();

    /**
     * @return string
     */
    function config();
}
