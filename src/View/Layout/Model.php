<?php
/**
 *
 */

namespace Mvc5\View\Layout;

use Mvc5\View\Model\Base;
use Mvc5\View\Model\Plugin;
use Mvc5\View\ViewPlugin;

class Model
    implements LayoutModel, Plugin
{
    /**
     *
     */
    use Base;
    use ViewPlugin;
}
