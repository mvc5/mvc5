<?php
/**
 *
 */

namespace Mvc5\View;

use function constant;
use function defined;

use const Mvc5\TEMPLATE_MODEL;

trait Model
{
    /**
     * @var ViewModel|null
     */
    protected ?ViewModel $model = null;

    /**
     * @param array $vars
     * @param string|null $template
     * @return ViewModel|mixed
     */
    protected function model(array $vars = [], string $template = null) : ViewModel
    {
        !$template && defined('static::TEMPLATE') && $template = constant('static::TEMPLATE');

        $template && $vars[TEMPLATE_MODEL] = $template;

        return $this->model ? $this->model->with($vars) : (
            (defined('static::VIEW_MODEL') && $model = constant('static::VIEW_MODEL'))
                ? new $model($vars) : new \Mvc5\ViewModel($vars)
        );
    }

    /**
     * @param string|null $template
     * @param array $vars
     * @return ViewModel|mixed
     */
    protected function view(string $template = null, array $vars = []) : ViewModel
    {
        return $this->model($vars, $template);
    }
}
