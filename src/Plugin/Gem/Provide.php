<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

interface Provide
    extends Gem
{
    /**
     * @return array
     */
    function args() : array;

    /**
     * @return mixed
     */
    function config();
}
