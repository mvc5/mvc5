<?php
/**
 *
 */

namespace Mvc5\Route\Definition\Url;

use Mvc5\Route\Definition\Build\Base;
use Mvc5\Route\Definition\Definition;

class Url
    implements Create
{
    /**
     *
     */
    use Base;

    /**
     * @param array|Definition $definition
     * @return Definition
     */
    public function __invoke($definition)
    {
        return $this->definition($definition, false);
    }
}
