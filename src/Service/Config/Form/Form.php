<?php
/**
 *
 */

namespace Mvc5\Service\Config\Form;

use Mvc5\Service\Config\Child\Base;
use Mvc5\Service\Resolver\Resolvable;

class Form
    implements FormService, Resolvable
{
    /**
     *
     */
    use Base;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->config = [
            self::NAME   => $name,
            self::PARENT => self::FORM
        ];
    }
}
