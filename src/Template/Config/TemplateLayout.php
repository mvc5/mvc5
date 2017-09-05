<?php
/**
 *
 */

namespace Mvc5\Template\Config;

use Mvc5\Arg;

trait TemplateLayout
{
    /**
     * @return mixed
     */
    function model()
    {
        return $this[Arg::CHILD_MODEL];
    }

    /**
     * @param mixed $model
     * @return self|mixed
     */
    function withModel($model)
    {
        return $this->with(Arg::CHILD_MODEL, $model);
    }
}
