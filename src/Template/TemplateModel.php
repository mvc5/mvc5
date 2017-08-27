<?php
/**
 *
 */

namespace Mvc5\Template;

interface TemplateModel
    extends \Mvc5\Config\Model
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
     * @param string $template
     * @return mixed|static
     */
    function withTemplate(string $template);
}
