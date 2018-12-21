<?php
/**
 *
 */

namespace Mvc5\Cookie;

use Mvc5\Config\Model;

interface Cookies
    extends Model
{
    /**
     * @return array
     */
    function all() : array;

    /**
     * @param string $name
     * @param string|null $value
     * @param array $options
     * @return self|mixed
     */
    function with($name, $value = null, array $options = []);

    /**
     * @param string $name
     * @param array $options
     * @return self|mixed
     */
    function without($name, array $options = []);
}
