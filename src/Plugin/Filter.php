<?php
/**
 *
 */

namespace Mvc5\Plugin;

class Filter
    implements Gem\Filter
{
    /**
     * @var Plugin|string
     */
    protected $config;

    /**
     * @var string|array
     */
    protected $filter;

    /**
     * @param $config
     * @param $filter
     */
    public function __construct($config, $filter = null)
    {
        $this->config = $config;
        $this->filter = (array) $filter;
    }

    /**
     * @return Plugin|string
     */
    public function config()
    {
        return $this->config;
    }

    /**
     * @return string|array
     */
    public function filter()
    {
        return $this->filter;
    }
}
