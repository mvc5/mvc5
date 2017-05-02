<?php
/**
 *
 */

namespace Mvc5\Template;

use Mvc5\Config\Immutable;

interface TemplateModel
    extends Immutable
{
    /**
     * @return null|string
     */
    function template();

    /**
     * @return array|null
     */
    function vars();

    /**
     * @param $template
     * @return mixed|static
     */
    function withTemplate($template);
}
