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
    function args() : array;

    /**
     * @return callable|mixed
     */
    function config();
}
