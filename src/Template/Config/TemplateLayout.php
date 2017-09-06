<?php
/**
 *
 */

namespace Mvc5\Template\Config;

use Mvc5\Arg;
use Mvc5\Template;

trait TemplateLayout
{
    /**
     * @return Template\TemplateModel|mixed
     */
    function model()
    {
        return $this[Arg::CHILD_MODEL];
    }

    /**
     * @param Template\TemplateModel|mixed $model
     * @return self|mixed
     */
    function withModel($model) : Template\TemplateLayout
    {
        return $this->with(Arg::CHILD_MODEL, $model);
    }
}
