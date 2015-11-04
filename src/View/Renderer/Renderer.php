<?php
/**
 *
 */

namespace Mvc5\View\Renderer;

use Mvc5\View\Manager\ManageView;
use Mvc5\View\ViewTemplates;

class Renderer
    implements ViewRenderer
{
    /**
     *
     */
    use ManageView;
    use RenderView;
    use ViewTemplates;
}
