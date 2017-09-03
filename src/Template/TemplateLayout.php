<?php
/**
 *
 */

namespace Mvc5\Template;

interface TemplateLayout
    extends TemplateModel
{
    /**
     * @return string|mixed
     */
    function model();

    /**
     * @param $model
     * @return self|mixed
     */
    function withModel($model);
}
