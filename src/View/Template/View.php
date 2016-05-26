<?php
/**
 *
 */

namespace Mvc5\View\Template;

use Mvc5\Model\Template;
use Mvc5\Model\ViewModel;

interface View
{
    /**
     * @param array|\ArrayAccess|null $config
     * @return array|\ArrayAccess|null
     */
    function templates($config = null);

    /**
     * @param Template|ViewModel $model
     * @return string
     */
    function render(Template $model);
}
