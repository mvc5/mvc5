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
     * @return array|Headers
     */
    function headers();

    /**
     * @return string|null
     */
    function reason();

    /**
     * @return int|null
     */
    function status();

    /**
     * @return string|null
     */
    function version();
}
