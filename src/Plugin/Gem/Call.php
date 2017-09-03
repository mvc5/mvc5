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
    function args() : array;

    /**
     * @return string|mixed
     */
    function config();
}
