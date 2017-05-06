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
     * @var null|string
     */
    protected $directory;

    /**
     * @var null|string
     */
    protected $extension = Arg::VIEW_EXTENSION;

    /**
     * @param $name
     * @return string
     */
    protected function find($name)
    {
        return $this->path($name) ?: (
            (!$name || !$this->directory || false !== strpos($name, '.')) ? $name :
                $this->directory . (DIRECTORY_SEPARATOR === $name[0] ? $name : DIRECTORY_SEPARATOR . $name) . '.' . $this->extension
        );
    }
}
