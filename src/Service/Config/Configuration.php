<?php
/**
 *
 */

namespace Mvc5\Service\Config;

use Mvc5\Config\Configuration as BaseConfiguration;

interface Configuration
    extends BaseConfiguration
{
    /**
     *
     */
    const ARGS = 'args';

    /**
     *
     */
    const CALLS = 'calls';

    /**
     *
     */
    const MERGE = 'merge';

    /**
     *
     */
    const NAME = 'name';

    /**
     *
     */
    const PARAM = 'item';

    /**
     * @return array
     */
    function args();

    /**
     * @return array
     */
    function calls();

    /**
     * @return bool
     */
    function merge();

    /**
     * @return string
     */
    function name();

    /**
     * @return string
     */
    function param();
}
