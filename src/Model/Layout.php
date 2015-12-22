<?php
/**
 *
 */

namespace Mvc5\Model;

interface Layout
    extends Template
{
    /**
     * @param null|string|Template $model
     * @return null|string
     */
    function model($model = null);
}
