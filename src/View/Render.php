<?php
/**
 *
 */

namespace Mvc5\View;

use Mvc5\Service;

class Render
    implements Service, Template\Paths, View
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
     * @param callable $provider
     * @param string $extension
     * @param string $model
     * @param bool|false $checkFileExists
     */
    function __construct($paths = [], $directory = null, callable $provider = null, $extension = null, $model = null, $checkFileExists = false)
    {
        $checkFileExists && $this->checkFileExists = $checkFileExists;
        $directory && $this->directory = $directory;
        $extension && $this->extension = $extension;
        $model && $this->model = $model;
        $paths && $this->path = $paths;
        $provider && $this->provider = $provider;
    }
}
