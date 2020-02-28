<?php
/**
 *
 */

namespace Mvc5\View;

use ArrayAccess;
use ArrayObject;
use Mvc5\Arg;
use Mvc5\Service\Service;
use Mvc5\ViewModel;

class Render
    implements View
{
    /**
     *
     */
    use Template\Find;
    use Template\Model;
    use Template\Render;

    /**
     * @param Service $service
     * @param ViewEngine $engine
     * @param array $options
     */
    function __construct(Service $service, ViewEngine $engine, array $options = [])
    {
        $this->engine = $engine;
        $this->service = $service;

        $this->directory = $options['directory'] ?? null;
        $this->extension = $options['extension'] ?? Arg::VIEW_EXTENSION;
        $this->model = $options['model'] ?? ViewModel::class;
        $this->paths = (fn($paths) => $paths instanceof ArrayAccess ? $paths :
            new ArrayObject($paths))($options['paths'] ?? null);
    }
}
