<?php
/**
 *
 */

namespace Mvc5\View;

use Mvc5\Arg;
use Mvc5\ViewModel;

trait Model
{
    /**
     * @var mixed|ViewModel
     */
    protected $model;

    /**
     * @param array $vars
     * @param null|string $template
     * @return mixed|ViewModel
     */
    protected function model(array $vars = [], string $template = null)
    {
        !$template && defined('static::TEMPLATE') && $template = constant('static::TEMPLATE');

        $template && $vars[Arg::TEMPLATE_MODEL] = $template;

        return $this->model ? $this->model->with($vars) : (
            (defined('static::VIEW_MODEL') && $model = constant('static::VIEW_MODEL'))
                ? new $model($vars) : new ViewModel($vars)
        );
    }

    /**
     * @param null|string $template
     * @param array $vars
     * @return mixed|ViewModel
     */
    protected function view(string $template = null, array $vars = [])
    {
        return $this->model($vars, $template);
    }
}
