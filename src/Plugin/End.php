<?php
/**
 *
 */

namespace Mvc5\Plugin;

class End
    extends Call
{
    /**
     * @param array ...$config
     */
    function __construct(...$config)
    {
        parent::__construct([$this, 'end'], [new Args($config)]);
    }

    /**
     * @param array $config
     * @return mixed
     */
    function end(array $config)
    {
        return end($config);
    }
}
