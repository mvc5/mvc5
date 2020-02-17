<?php
/**
 *
 */

namespace Mvc5\View;

use Mvc5\Arg;

use function constant;
use function defined;

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

        $template && $vars[Arg::TEMPLATE_MODEL] = $template;

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
