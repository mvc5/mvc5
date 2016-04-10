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
    function args();

    /**
     * @return mixed
     */
    function config();
}
