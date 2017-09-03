<?php
/**
 *
 */

namespace Mvc5\Template\Config;

use Mvc5\Arg;

trait TemplateLayout
{
    /**
     * @return string|null
     */
    function model()
    {
        return $this[Arg::CHILD_MODEL];
    }

    /**
     * @param $model
     * @return self|mixed
     */
    function withModel($model)
    {
        return $this->with(Arg::CHILD_MODEL, $model);
    }
}
