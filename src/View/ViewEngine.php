<?php
/**
 *
 */

namespace Mvc5\View;

use Mvc5\Template\TemplateModel;

interface ViewEngine
{
    /**
     * @param TemplateModel $model
     * @return string
     */
    function render(TemplateModel $model);
}
