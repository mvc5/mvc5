<?php
/**
 *
 */

namespace Mvc5\Http;

use Mvc5\Config\Model;

interface Error
    extends \JsonSerializable, Model
{
    /**
     * @return int|null
     */
    function code() : ?int;

    /**
     * @return string|null
     */
    function description() : ?string;

    /**
     * @return array
     */
    function errors() : array;

    /**
     * @return string|null
     */
    function message() : ?string;

    /**
     * @return int|null
     */
    function status() : ?int;
}
