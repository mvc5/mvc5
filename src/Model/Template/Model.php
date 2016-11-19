<?php
/**
 *
 */

namespace Mvc5\Model\Template;

use Mvc5\Arg;
use Mvc5\Config\Overload;

trait Model
{
    /**
     *
     */
    use Overload;

    /**
     * @param array|string $template
     * @param array $vars
     */
    function __construct($template = null, array $vars = [])
    {
        $this->config = (is_array($template) ? $template : $vars) + array_filter([
            Arg::TEMPLATE_MODEL => is_string($template) ? $template :
                (defined('static::TEMPLATE_NAME') ? constant('static::TEMPLATE_NAME') : null)
        ]);
    }

    /**
     * @param null|string $path
     * @return null|string
     */
    function template($path = null)
    {
        return null === $path ? $this[Arg::TEMPLATE_MODEL] : $this[Arg::TEMPLATE_MODEL] = $path;
    }

    /**
     * @param array|null $vars
     * @return array|null
     */
    function vars(array $vars = null)
    {
        return null === $vars ? $this->config :
            $this->config = $vars + $this->config + array_filter([Arg::TEMPLATE_MODEL => $this->template()]);
    }
}
