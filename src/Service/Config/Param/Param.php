<?php
/**
 *
 */

namespace Mvc5\Service\Config\Param;

use Mvc5\Service\Resolver\Resolvable;

class Param
    implements Resolvable, ServiceParam
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
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
