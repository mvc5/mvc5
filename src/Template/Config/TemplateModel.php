<?php
/**
 *
 */

namespace Mvc5\Template\Config;

use Mvc5\Arg;
use Mvc5\Template;

trait TemplateModel
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @param array|string $template
     * @param array $vars
     */
    function __construct($template = null, array $vars = [])
    {
        $this->config = (is_array($template) ? $template + $vars : $vars) + array_filter([
            Arg::TEMPLATE_MODEL => is_string($template) ? $template :
                (defined('static::TEMPLATE') ? constant('static::TEMPLATE') : null)
        ]);
    }

    /**
     * @return string|null
     */
    function template()
    {
        return $this[Arg::TEMPLATE_MODEL];
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
     * @return self|mixed
     */
    function withTemplate(string $template) : Template\TemplateModel
    {
        return $this->with(Arg::TEMPLATE_MODEL, $template);
    }
}
