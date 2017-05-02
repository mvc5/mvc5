<?php
/**
 *
 */

namespace Mvc5\Template\Config;

use Mvc5\Arg;
use Mvc5\Config\ReadOnly;

trait Model
{
    /**
     *
     */
    use ReadOnly;

    /**
     * @param array|string $template
     * @param array $vars
     */
    function __construct($template = null, array $vars = [])
    {
        $this->config = (is_array($template) ? $template + $vars : $vars) + array_filter([
            Arg::TEMPLATE_MODEL => is_string($template) ? $template :
                (defined('static::TEMPLATE_NAME') ? constant('static::TEMPLATE_NAME') : null)
        ]);
    }

    /**
     * @return null|string
     */
    function template()
    {
        return $this[Arg::TEMPLATE_MODEL];
    }

    /**
     * @return array|null
     */
    function vars()
    {
        return $this->config;
    }

    /**
     * @param $template
     * @return mixed|static
     */
    function withTemplate($template)
    {
        return $this->with(Arg::TEMPLATE_MODEL, $template);
    }
}
