<?php
/**
 *
 */

namespace Mvc5\Template;

interface TemplateLayout
    extends TemplateModel
{
    /**
     * @return TemplateModel|mixed
     */
    function model();

    /**
     * @param TemplateModel|mixed $model
     * @return self|mixed
     */
    function withModel($model);
}
