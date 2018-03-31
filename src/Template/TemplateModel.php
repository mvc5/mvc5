<?php
/**
 *
 */

namespace Mvc5\Template;

interface TemplateModel
    extends \Mvc5\Config\Model
{
    /**
     * @return string|null
     */
    function template() : ?string;

    /**
     * @return array
     */
    function vars() : array;

    /**
     * @param string $template
     * @return self|mixed
     */
    function withTemplate(string $template);
}
