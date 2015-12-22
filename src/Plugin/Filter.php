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
     * @var array
     */
    protected $filter;

    /**
     * @param $config
     * @param array $filter
     */
    public function __construct($config, array $filter = [])
    {
        $this->config = $config;
        $this->filter = $filter;
    }

    /**
     * @return array
     */
    public function filter()
    {
        return $this->filter;
    }
}
