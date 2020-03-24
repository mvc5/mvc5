<?php
/**
 *
 */

namespace Mvc5\View;

use Mvc5\Service\Service;
use Mvc5\ViewModel;

use const Mvc5\VIEW_EXTENSION;

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
        $this->extension = $options['extension'] ?? VIEW_EXTENSION;
        $this->model = $options['model'] ?? ViewModel::class;
        $this->paths = (array) ($options['paths'] ?? null);
    }
}
