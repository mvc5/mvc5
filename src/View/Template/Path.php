<?php
/**
 *
 */

namespace Mvc5\View\Template;

trait Path
{
    /**
     * @var array
     */
    protected array $paths;

    /**
     * @param string $name
     * @return string|null
     */
    protected function path(string $name) : ?string
    {
        return $this->paths[$name] ?? null;
    }
}
