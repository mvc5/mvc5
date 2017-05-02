<?php
/**
 *
 */

namespace Mvc5\View;

use Mvc5\Service\Service;
use Mvc5\Template\TemplateModel;

interface ViewModel
    extends TemplateModel
{
    /**
     * @return null|Service
     */
    function service();

    /**
     * @param Service $service
     * @return mixed|static
     */
    function withService(Service $service);

    /**
     * @param $name
     * @param array $args
     * @return mixed
     */
    function __call($name, array $args = []);
}
