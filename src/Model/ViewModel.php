<?php
/**
 *
 */

namespace Mvc5\Model;

use Mvc5\Config\Configuration;
use Mvc5\Service;

interface ViewModel
    extends Configuration, Service
{
    /**
     * @return array
     */
    function assigned();

    /**
     * @param string|self $model
     * @return void
     */
    function child($model);

    /**
     * @return string|self
     */
    function model();

    /**
     * @return string
     */
    function path();

    /**
     * @param string $path
     * @return void
     */
    function template($path);

    /**
     * @param array $config
     * @return void
     */
    function vars(array $config = []);

    /**
     * @param $name
     * @param array $args
     * @return mixed
     */
    function __call($name, array $args = []);
}
