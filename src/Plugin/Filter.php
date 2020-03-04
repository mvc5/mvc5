<?php
/**
 *
 */

namespace Mvc5\Plugin;

use Mvc5\Resolvable;
use Throwable;
use Traversable;

class Filter
    implements Gem\Filter
{
    /**
     *
     */
    use Config\Args;
    use Config\Config;

    /**
     * @var Resolvable
     */
    protected Resolvable $filter;

    /**
     * @var string|null
     */
    protected ?string $param = null;

    /**
     * @param string|mixed $config
     * @param array|Resolvable|Traversable $filter
     * @param array $args
     * @param string|null $param
     * @throws Throwable
     */
    function __construct($config, $filter = [], array $args = [], string $param = null)
    {
        $this->args   = $args;
        $this->config = $config;
        $this->filter = $filter instanceof Resolvable ? $filter : new Value($filter);
        $this->param  = $param;
    }

    /**
     * @return string|null
     */
    function param() : ?string
    {
        return $this->param;
    }

    /**
     * @return Resolvable
     */
    function plugin() : Resolvable
    {
        return $this->filter;
    }
}
