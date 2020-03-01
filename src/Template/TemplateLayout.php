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
     * @return TemplateLayout
     */
    function withModel($model) : TemplateLayout;
}
