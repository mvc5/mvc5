<?php
/**
 *
 */

namespace Mvc5\Service\Container;

use Countable;
use Mvc5\Config\Base;
use Iterator;

class Config
    implements Countable, Iterator, ServiceCollection
{
    /**
     *
     */
    use Base;
}
