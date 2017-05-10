<?php
/**
 *
 */

namespace Mvc5\Template\Config;

use Mvc5\Arg;

trait TemplateLayout
{
    /**
     * @return null|string
     */
    function model()
    {
        return $this[Arg::CHILD_MODEL];
    }

    /**
     * @param $model
     * @return mixed|static
     */
    function withModel($model)
    {
        return $this->with(Arg::CHILD_MODEL, $model);
    }
}
