<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

interface Invokable
    extends Gem
{
    /**
     * @return array
     */
    function args();

    /**
     * @return array|callable|object|Plugin|string
     */
    function config();
}
