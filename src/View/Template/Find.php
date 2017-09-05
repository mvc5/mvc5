<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Mvc5\Arg;

trait Find
{
    /**
     *
     */
    use Path;

    /**
     * @var string|null
     */
    protected $directory;

    /**
     * @var string|null
     */
    protected $extension = Arg::VIEW_EXTENSION;

    /**
     * @param string $name
     * @return string
     */
    protected function find(string $name) : string
    {
        return $this->path($name) ?? (
            (!$name || !$this->directory || false !== strpos($name, '.')) ? $name :
                $this->directory . (DIRECTORY_SEPARATOR === $name[0] ? $name : DIRECTORY_SEPARATOR . $name) . '.' . $this->extension
        );
    }
}
