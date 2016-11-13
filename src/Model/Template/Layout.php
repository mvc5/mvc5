<?php
/**
 *
 */

namespace Mvc5\Model\Template;

use Mvc5\Arg;

trait Layout
{
    /**
     *
     */
    use Model;

    /**
     * @param null|string $model
     * @return null|string
     */
    function model($model = null)
    {
        return null === $model ? $this[Arg::CHILD_MODEL] : $this[Arg::CHILD_MODEL] = $model;
    }

    /**
     * @param array|null $vars
     * @return array|null
     */
    function vars(array $vars = null)
    {
        return null === $vars ? $this->config : $this->config = $vars + $this->config + array_filter([
            Arg::CHILD_MODEL    => $this->model(),
            Arg::TEMPLATE_MODEL => $this->template()
        ]);
    }
}
