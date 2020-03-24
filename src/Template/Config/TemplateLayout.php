<?php
/**
 *
 */

namespace Mvc5\Template\Config;

use Mvc5\Template;

use const Mvc5\CHILD_MODEL;

trait TemplateLayout
{
    /**
     * @return Template\TemplateModel|mixed
     */
    function model()
    {
        return $this[CHILD_MODEL];
    }

    /**
     * @param Template\TemplateModel|mixed $model
     * @return Template\TemplateLayout
     */
    function withModel($model) : Template\TemplateLayout
    {
        return $this->with(CHILD_MODEL, $model);
    }
}
