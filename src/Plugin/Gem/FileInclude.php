<?php
/**
 *
 */

namespace Mvc5\Plugin\Gem;

use Mvc5\Resolvable;

interface FileInclude
    extends Resolvable
{
    /**
     * @return Plugin|string
     */
    function config();
}
