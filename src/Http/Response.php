<?php
/**
 *
 */

namespace Mvc5\Http;

use Mvc5\Config\Model;

interface Response
    extends Model
{
    /**
     * @return mixed
     */
    function body();

    /**
     * @return array|mixed
     */
    function headers();

    /**
     * @return string
     */
    function reason();

    /**
     * @return int
     */
    function status();

    /**
     * @return string
     */
    function version();
}
