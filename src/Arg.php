<?php
/**
 *
 */

namespace Mvc5;

interface Arg
{
    /**
     *
     */
    const ARGS = 'args';

    /**
     *
     */
    const CALL = '@';

    /**
     *
     */
    const CONFIG = 'config';

    /**
     *
     */
    const CONTAINER = 'container';

    /**
     *
     */
    const CHILD_MODEL = '__child';

    /**
     *
     */
    const CONTROLLER = 'controller';

    /**
     *
     */
    const CALLS = 'calls';

    /**
     *
     */
    const CALL_SEPARATOR = '.';

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
    const CONTROLLER_EXCEPTION = 'controller\exception';

    /**
     *
     */
    const DEFAULTS = 'defaults';

    /**
     *
     */
    const DEFINITION = 'definition';

    /**
     *
     */
    const EVENT = 'event';

    /**
     *
     */
    const EVENT_MODEL = 'event\model';

    /**
     *
     */
    const EVENTS = 'events';

    /**
     *
     */
    const EXCEPTION = 'exception';

    /**
     *
     */
    const EXCEPTION_DISPATCH = 'exception\dispatch';

    /**
     *
     */
    const FACTORY = 'factory';

    /**
     *
     */
    const FORM = 'form';

    /**
     *
     */
    const HOSTNAME = 'hostname';

    /**
     *
     */
    const INDEX = '#';

    /**
     *
     */
    const ITEM = 'item';

    /**
     *
     */
    const LENGTH = 'length';

    /**
     *
     */
    const MANAGER = 'manager';

    /**
     *
     */
    const MAX_RECURSION = 100;

    /**
     *
     */
    const MERGE = 'merge';

    /**
     *
     *
     */
    const MODEL = 'model';

    /**
     *
     */
    const MATCHED = 'matched';

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
    const PARAM = 'param';

    /**
     *
     */
    const PARAM_MAP = 'paramMap';

    /**
     *
     */
    const PARAMS = 'params';

    /**
     *
     */
    const PARENT = 'parent';

    /**
     *
     */
    const PATH = 'path';

    /**
     *
     */
    const PLUGIN = 'plugin';

    /**
     *
     */
    const PROPERTY = '$';

    /**
     *
     */
    const REGEX = 'regex';

    /**
     *
     */
    const REQUEST = 'request';

    /**
     *
     */
    const RESPONSE = 'response';

    /**
     *
     */
    const RESPONSE_DISPATCH = 'response\dispatch';

    /**
     *
     */
    const RESPONSE_EXCEPTION = 'response\exception';

    /**
     *
     */
    const ROUTE = 'route';

    /**
     *
     */
    const ROUTE_GENERATOR = 'route\generator';

    /**
     *
     */
    const ROUTE_DISPATCH = 'route\dispatch';

    /**
     *
     */
    const ROUTE_EXCEPTION = 'route\exception';

    /**
     *
     */
    const ROUTE_MATCH = 'route\match';

    /**
     *
     */
    const SCHEME = 'scheme';

    /**
     *
     */
    const SEPARATOR = '/';

    /**
     *
     */
    const SERVICE = 'service';

    /**
     *
     */
    const SERVICE_RESOLVER = 'service\resolver';

    /**
     *
     */
    const SERVICE_SEPARATOR = '->';

    /**
     *
     */
    const SERVICES = 'services';
    /**
     *
     */
    const TEMPLATE = 'template';

    /**
     *
     */
    const TEMPLATE_MODEL = '__template';

    /**
     *
     */
    const TOKENS = 'tokens';

    /**
     *
     */
    const VIEW_RENDER = 'view\render';

    /**
     *
     */
    const VIEW_EXCEPTION = 'view\exception';

    /**
     *
     */
    const WEB = 'web';

    /**
     *
     */
    const WILDCARD = 'wildcard';
}
