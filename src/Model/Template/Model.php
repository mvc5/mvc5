<?php
/**
 *
 */

namespace Mvc5\Model\Template;

use Mvc5\Arg;
use Mvc5\Config\Config;
use Mvc5\Config\PropertyAccess;

trait Model
{
    /**
     *
     */
    use Config;
    use PropertyAccess;

    /**
     * @param $template
     * @param array $config
     */
    function __construct($template = null, array $config = [])
    {
        $this->config = $config + array_filter([
                Arg::TEMPLATE_MODEL => $template ?? (
                    defined('static::TEMPLATE_NAME') ? constant('static::TEMPLATE_NAME') : null
                    )
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
     * @param array|null $config
     * @return array|null
     */
    function vars(array $config = null)
    {
        return null === $config ? $this->config :
            $this->config = $config + $this->config + array_filter([Arg::TEMPLATE_MODEL => $this->template()]);
    }
}
