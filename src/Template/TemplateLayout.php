<?php
/**
 *
 */

namespace Mvc5\Template;

interface TemplateLayout
    extends TemplateModel
{
    /**
     * @return null|string
     */
    function model();

    /**
     * @param $model
     * @return mixed|static
     */
    function withModel($model);
}
