<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

use Mvc5\Config\Configuration;

interface Definition
    extends Configuration
{
    /**
     *
     */
    const CHILDREN = 'children';

    /**
     *
     */
    const CLASS_NAME = 'class';

    /**
     *
     */
    const CONSTRAINTS = 'constraints';

    /**
     *
     */
    const CONTROLLER = 'controller';

    /**
     *
     */
    const DEFAULTS = 'defaults';

    /**
     *
     */
    const HOSTNAME = 'hostname';

    /**
     *
     */
    const METHOD = 'method';

    /**
     *
     */
    const NAME = 'name';

    /**
     *
     */
    const PARAM_MAP = 'paramMap';

    /**
     *
     */
    const REGEX = 'regex';

    /**
     *
     */
    const ROUTE = 'route';

    /**
     *
     */
    const SCHEME = 'scheme';

    /**
     *
     */
    const TOKENS = 'tokens';

    /**
     *
     */
    const WILDCARD = 'wildcard';

    /**
     * @param $name
     * @param array|Definition $definition
     * @return void
     */
    function add($name, $definition);

    /**
     * @param string $name
     * @return self
     */
    function child($name);

    /**
     * @return self[]
     */
    function children();

    /**
     * @return null|string
     */
    function className();

    /**
     * @return array
     */
    function constraints();

    /**
     * @return array|callable|object|string
     */
    function controller();

    /**
     * @return array
     */
    function defaults();

    /**
     * @return null|string|string[]
     */
    function hostname();

    /**
     * @return string
     */
    function method();

    /**
     * @return string
     */
    function name();

    /**
     * @return array
     */
    function paramMap();

    /**
     * @return string
     */
    function regex();

    /**
     * @return string
     */
    function route();

    /**
     * @return null|string|string[]
     */
    function scheme();

    /**
     * @return array
     */
    function tokens();

    /**
     * @return bool
     */
    function wildcard();
}
