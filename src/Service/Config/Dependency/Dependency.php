<?php
/**
 *
 */

namespace Mvc5\Service\Config\Dependency;

use Mvc5\Service\Resolver\Resolvable;

class Dependency
    implements Resolvable, ServiceDependency
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }
}
