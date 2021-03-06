<?php
/**
 *
 */

namespace Mvc5\Template\Config;

use Mvc5\Template;

use function array_filter;
use function constant;
use function defined;
use function is_array;
use function is_string;

use const Mvc5\TEMPLATE_MODEL;

trait TemplateModel
{
    /**
     * @var array
     */
    protected array $config = [];

    /**
     * @param array|string $template
     * @param array $vars
     */
    function __construct($template = null, array $vars = [])
    {
        $this->config = (is_array($template) ? $template + $vars : $vars) + array_filter([
            TEMPLATE_MODEL => is_string($template) ? $template :
                (defined('static::TEMPLATE') ? constant('static::TEMPLATE') : null)
        ]);
    }

    /**
     * @return string|null
     */
    function template() : ?string
    {
        return $this[TEMPLATE_MODEL];
    }

    /**
     * @return array
     */
    function vars() : array
    {
        return $this->config;
    }

    /**
     * @param string $template
     * @return Template\TemplateModel
     */
    function withTemplate(string $template) : Template\TemplateModel
    {
        return $this->with(TEMPLATE_MODEL, $template);
    }
}
