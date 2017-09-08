<?php
/**
 *
 */

namespace Mvc5\View;

use Mvc5\Overload;
use Mvc5\Service\Service;

class SharedLayout
    extends Overload
    implements ViewLayout
{
    /**
     *
     */
    use Config\ViewLayout;

    /**
     * @param array|string $name
     * @param mixed $value
     * @return ViewLayout
     */
    function with($name, $value = null) : ViewLayout
    {
        $this->set($name, $value);
        return $this;
    }

    /**
     * @param array|string $name
     * @return ViewLayout
     */
    function without($name) : ViewLayout
    {
        $this->remove($name);
        return $this;
    }

    /**
     * @param Service $service
     * @return ViewLayout
     */
    function withService(Service $service) : ViewLayout
    {
        $this->service = $service;
        return $this;
    }
}
