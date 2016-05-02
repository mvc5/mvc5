<?php
/**
 *
 */

namespace Mvc5\Model\Template;

use Mvc5\Arg;
use Mvc5\Config\Config;

trait Model
{
    /**
     *
     */
    use Config;

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

    /**
     * @param $name
     * @return mixed
     */
    function __get($name)
    {
        return $this->get($name);
    }

    /**
     * @param $name
     * @return bool
     */
    function __isset($name)
    {
        return $this->has($name);
    }

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    function __set($name, $value)
    {
        return $this->set($name, $value);
    }

    /**
     * @param $name
     * @return mixed
     */
    function __unset($name)
    {
        $this->remove($name);
    }
}
