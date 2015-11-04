<?php
/**
 *
 */

namespace Mvc5\View\Renderer;

use Mvc5\View\Model\ViewModel;

interface ViewRenderer
{
    /**
     * @param ViewModel $model
     * @return string
     */
    function __invoke(ViewModel $model);
}
