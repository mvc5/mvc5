<?php
/**
 *
 */

namespace Mvc5\View\Template;

interface Paths
{
    /**
     * @param array|\ArrayAccess|null $paths
     * @return array|\ArrayAccess|null
     */
    function paths($paths = null);
}
