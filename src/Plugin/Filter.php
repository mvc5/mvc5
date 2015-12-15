<?php
/**
 *
 */

namespace Mvc5\Plugin;

class Filter
    implements Gem\Filter
{
    /**
     *
     */
    use Config\Config;

    /**
     * @var string|array
     */
    protected $filter;

    /**
     * @param $config
     * @param array|\Traversable $filter
     */
    public function __construct($config, $filter = [])
    {
        $this->config = $config;
        $this->filter = $filter;
    }

    /**
     * @return string|array
     */
    public function filter()
    {
        return $this->filter;
    }
}
