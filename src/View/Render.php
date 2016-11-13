<?php
/**
 *
 */

namespace Mvc5\View;

class Render
    implements Template\Paths, View
{
    /**
     *
     */
    use Template\Find;
    use Template\Model;
    use Template\Render;

    /**
     * @param array|\ArrayAccess $paths
     * @param string $directory
     * @param string $extension
     * @param string $model
     */
    function __construct($paths = [], $directory = null, $extension = null, $model = null)
    {
        $this->directory = $directory;
        $this->path = $paths;

        $extension && $this->extension = $extension;
        $model && $this->model = $model;
    }
}
