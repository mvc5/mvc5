<?php
/**
 *
 */

namespace Mvc5\View\Model;

use Mvc5\Model\ViewModel;
use Mvc5\Model\Template;

interface Service
{
    /**
     * @param array $vars
     * @param null|string $template
     * @return Template|ViewModel
     */
    function model(array $vars = [], $template = null);

    /**
     * @param Template|ViewModel $model
     * @return Template|ViewModel
     */
    function setModel(Template $model);

    /**
     * @param string $template
     * @param array $vars
     * @return Template|ViewModel
     */
    function view($template = null, array $vars = []);
}
