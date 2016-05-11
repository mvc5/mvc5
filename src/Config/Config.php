<?php
/**
 *
 */

namespace Mvc5\Config;

use Mvc5\Service\Scope;

trait Config
{
    /**
     *
     */
    use ArrayAccess;

    /**
     * @var array|Configuration
     */
    protected $config = [];

    /**
     * @param array $config
     */
    function __construct($config = [])
    {
        $this->config = $config;
    }

    /**
     * @return int
     */
    function count()
    {
        return count($this->config);
    }

    /**
     * @return mixed
     */
    function current()
    {
        return is_array($this->config) ? current($this->config) : $this->config->current();
    }

    /**
     * @param string $name
     * @return mixed
     */
    function get($name)
    {
        return is_array($this->config) ?
            (isset($this->config[$name]) ? $this->config[$name] : null) : $this->config[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    function has($name)
    {
        return isset($this->config[$name]);
    }

    /**
     * @return mixed
     */
    function key()
    {
        return is_array($this->config) ? key($this->config) : $this->config->key();
    }

    /**
     *
     */
    function next()
    {
        is_array($this->config) ? next($this->config) : $this->config->next();
    }

    /**
     * @param string $name
     * @return void
     */
    function remove($name)
    {
        unset($this->config[$name]);
    }

    /**
     *
     */
    function rewind()
    {
        is_array($this->config) ? reset($this->config) : $this->config->rewind();
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    function set($name, $value)
    {
        return $this->config[$name] = $value;
    }

    /**
     * @return bool
     */
    function valid()
    {
        return is_array($this->config) ? null !== $this->key() : $this->config->valid();
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return self|mixed
     */
    function with($name, $value)
    {
        $new = clone $this;
        $new->set($name, $value);
        return $new;
    }

    /**
     * @param string $name
     * @return self|mixed
     */
    function without($name)
    {
        $new = clone $this;
        $new->remove($name);
        return $new;
    }

    /**
     *
     */
    function __clone()
    {
        if (!is_object($this->config)) {
            return null;
        }

        if (!$this->config instanceof Scope) {
            return $this->config = clone $this->config;
        }

        $scope = $this->config->scope();

        if (!$scope instanceof self) {
            return $this->config = clone $this->config;
        }

        $this->config->scope(false);

        $clone = clone $this->config;
        $clone->scope($this);

        $this->config->scope($scope);

        return $this->config = $clone;
    }
}
