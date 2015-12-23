<?php
/**
 *
 */

namespace Mvc5\Model\Template;

use Mvc5\Arg;

trait Layout
{
    /**
     *
     */
    use Model;

    /**
     * @param null|string $model
     * @return null|string
     */
    public function model($model = null)
    {
        return null === $model ? $this[Arg::CHILD_MODEL] : $this[Arg::CHILD_MODEL] = $model;
    }

    /**
     * @param array|null $config
     * @return array|null
     */
    public function vars(array $config = null)
    {
        return null === $config ? $this->config : $this->config = $config + $this->config + array_filter([
                Arg::CHILD_MODEL    => $this->model(),
                Arg::TEMPLATE_MODEL => $this->template()
            ]);
    }
}
