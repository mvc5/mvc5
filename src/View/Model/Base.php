<?php
/**
 *
 */

namespace Mvc5\View\Model;

use Mvc5\Config\Base as ConfigBase;

trait Base
{
    /**
     *
     */
    use ConfigBase;

    /**
     * @param $template
     * @param array $config
     */
    public function __construct($template = null, array $config = [])
    {
        $this->config = $config + [
            ViewModel::TEMPLATE => $template
                ?: (defined('static::TEMPLATE_NAME') ? constant('static::TEMPLATE_NAME') : null)
        ];
    }

    /**
     * @param string|ViewModel $model
     * @return void
     */
    public function child($model)
    {
        $this->set(ViewModel::CHILD, $model);
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
        return $this->get(ViewModel::CHILD);
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->get(ViewModel::TEMPLATE);
    }

    /**
     * @param string $template
     * @return void
     */
    public function template($template)
    {
        $this->set(ViewModel::TEMPLATE, $template);
    }

    /**
     * @param array $config
     * @return void
     */
    public function vars(array $config = [])
    {
        $this->config = $config + $this->config + [
                ViewModel::TEMPLATE => $this->path(),
                ViewModel::CHILD    => $this->model()
            ];
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
