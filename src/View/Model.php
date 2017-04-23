<?php
/**
 *
 */

namespace Mvc5\View;

use Mvc5\Arg;
use Mvc5\Model as Mvc5Model;
use Mvc5\Model\ViewModel;
use Mvc5\Model\Template;

trait Model
{
    /**
     * @var Template|ViewModel
     */
    protected $model;

    /**
     * @param array $vars
     * @param null|string $template
     * @return Template|ViewModel
     */
    function model(array $vars = [], $template = null)
    {
        !$template && defined('static::TEMPLATE_NAME')
            && $template = constant('static::TEMPLATE_NAME');

        $template && $vars[Arg::TEMPLATE_MODEL] = $template;

        return $this->model ? $this->model->with($vars) : (
            (defined('static::VIEW_MODEL') && $model = constant('static::VIEW_MODEL'))
                ? new $model($vars) : new Mvc5Model($vars)
        );
    }

    /**
     * @param Template|ViewModel $model
     * @return Template|ViewModel
     */
    function setModel(Template $model)
    {
        return $this->model = $model;
    }

    /**
     * @param string $template
     * @param array $vars
     * @return Template|ViewModel
     */
    function view($template = null, array $vars = [])
    {
        return $this->model($vars, $template);
    }
}
