<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Mvc5\Model\ViewModel;

interface View
{
    /**
     * @param array|\ArrayAccess|null $config
     * @return array|\ArrayAccess|null
     */
    function templates($config = null);

    /**
     * @param mixed|ViewModel $model
     * @return string
     */
    function __invoke($model);
}
