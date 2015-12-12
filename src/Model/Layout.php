<?php
/**
 *
 */

namespace Mvc5\Model;

interface Layout
    extends Template
{
    /**
     * @param null|string $model
     * @return null|string
     */
    function model($model = null);
}
