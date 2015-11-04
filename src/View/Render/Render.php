<?php
/**
 *
 */

namespace Mvc5\View\Render;

use Mvc5\Event\Event;
use Mvc5\Service\Resolver\EventSignal;
use Mvc5\View\Model\ViewModel;

class Render
    implements Event, RenderView
{
    /**
     *
     */
    use EventSignal;

    /**
     *
     */
    const EVENT = self::VIEW;

    /**
     * @var ViewModel
     */
    protected $model;

    /**
     * @param ViewModel $model
     */
    public function __construct($model = null)
    {
        $this->model = $model;
    }

    /**
     * @return array
     */
    protected function args()
    {
        return [
            Args::EVENT => $this,
            Args::MODEL => $this->model
        ];
    }
}
