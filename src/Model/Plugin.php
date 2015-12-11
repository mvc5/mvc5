<?php
/**
 *
 */

namespace Mvc5\Model;

use Mvc5\Arg;
use Mvc5\Config\Config;
use Mvc5\Plugin as Service;

trait Plugin
{
    /**
     *
     */
    use Config;
    use Service;

    /**
     * @param $template
     * @param array $config
     */
    public function __construct($template = null, array $config = [])
    {
        $this->config = $config + [
            Arg::TEMPLATE_MODEL => $template ?? (
                defined('static::TEMPLATE_NAME') ? constant('static::TEMPLATE_NAME') : null
            )
        ];
    }

    /**
     * @param string|self $model
     * @return void
     */
    public function child($model)
    {
        $this->set(Arg::CHILD_MODEL, $model);
    }

    /**
     * @return array
     */
    public function assigned()
    {
        return $this->config;
    }

    /**
     * @return string|self
     */
    public function model()
    {
        return $this->get(Arg::CHILD_MODEL);
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->get(Arg::TEMPLATE_MODEL);
    }

    /**
     * @param string $template
     * @return void
     */
    public function template($template)
    {
        $this->set(Arg::TEMPLATE_MODEL, $template);
    }

    /**
     * @param array $config
     * @return void
     */
    public function vars(array $config = [])
    {
        $this->config = $config + $this->config + [
                Arg::TEMPLATE_MODEL => $this->path(),
                Arg::CHILD_MODEL    => $this->model()
            ];
    }

    /**
     * @param string $name
     * @param array $args
     * @return mixed
     */
    public function __call($name, array $args = [])
    {
        return $this->call($name, $args);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return $this->has($name);
    }

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __unset($name)
    {
        $this->remove($name);
    }
}
