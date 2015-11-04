<?php
/**
 *
 */

namespace Mvc5\Service\Factory;

use Mvc5\Config\Configuration;
use Mvc5\Service\Manager\ServiceManager;

trait Base
{
    /**
     * @var ServiceManager
     */
    protected $sm;

    /**
     * @param ServiceManager $sm
     */
    public function __construct(ServiceManager $sm)
    {
        $this->sm = $sm;
    }

    /**
     * @return Configuration
     */
    public function config()
    {
        return $this->sm->config();
    }

    /**
     * @param $name
     * @return array|callable|null|object|string
     */
    public function configured($name)
    {
        return $this->sm->configured($name);
    }

    /**
     * @param string $name
     * @param array $args
     * @return null|object|callable
     */
    public function create($name, array $args = [])
    {
        return $this->sm->create($name, $args);
    }

    /**
     * @param array|string $name
     * @param array $args
     * @return null|object
     */
    public function get($name, array $args = [])
    {
        return $this->sm->get($name, $args);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function param($name)
    {
        return $this->sm->param($name);
    }

    /**
     * @param $name
     * @return object
     */
    public function service($name)
    {
        return $this->sm->service($name);
    }
}
