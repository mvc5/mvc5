<?php
/**
 *
 */

namespace Mvc5\Template;

use Mvc5\ArrayModel;

class Layout
    extends ArrayModel
    implements TemplateLayout
{
    /**
     *
     */
    use Config\TemplateLayout;
    use Config\TemplateModel;
}
