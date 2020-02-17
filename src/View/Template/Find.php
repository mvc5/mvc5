<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Mvc5\Arg;

use function strpos;

trait Find
{
    /**
     *
     */
    use Path;

    /**
     * @var string|null
     */
    protected ?string $directory = null;

    /**
     * @var string|null
     */
    protected string $extension = Arg::VIEW_EXTENSION;

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
