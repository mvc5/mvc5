<?php
/**
 *
 */

namespace Mvc5\Route;

class Generator
{
    /**
     *
     */
    use Definition\Build;

    /**
     * @var string
     */
    protected $class = Definition\Config::class;

    /**
     * @param null|string $class
     */
    public function __construct($class = null)
    {
        $class && $this->class = $class;
    }

    /**
     * @param array $definition
     * @return string
     */
    protected function createDefault(array $definition = [])
    {
        return new $this->class($definition);
    }

    /**
     * @param array|Definition $definition
     * @param bool $compile
     * @param bool $recursive
     * @return Definition
     */
    public function __invoke($definition, $compile = true, $recursive = false)
    {
        return $this->build($definition, $compile, $recursive);
    }
}
