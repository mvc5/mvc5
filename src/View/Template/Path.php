<?php
/**
 *
 */

namespace Mvc5\View\Template;

use ArrayAccess;

trait Path
{
    /**
     * @var ArrayAccess
     */
    protected ArrayAccess $paths;

    /**
     * @param string $name
     * @return string|null
     */
    protected function path(string $name) : ?string
    {
        return $this->paths[$name] ?? null;
    }
}
