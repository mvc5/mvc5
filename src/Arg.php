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
    const ACTION = 'action';

    /**
     *
     */
    const ARGS = 'args';

    /**
     *
     */
    const BODY = 'body';

    /**
     *
     */
    const CALL = '@';

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
    const CANONICAL = 'canonical';

    /**
     *
     */
    const CHILDREN = 'children';

    /**
     *
     */
    const CHILD_MODEL = '__child';

    /**
     *
     */
    const CLASS_NAME = 'class';

    /**
     *
     */
    const CLIENT_ADDRESS = 'client_address';

    /**
     *
     */
    const CODE = 'code';

    /**
     *
     */
    const CONFIG = 'config';

    /**
     *
     */
    const CONSTRAINTS = 'constraints';

    /**
     *
     */
    const CONTAINER = 'container';

    /**
     *
     */
    const CONTENT_TYPE = 'content_type';

    /**
     *
     */
    const CONTROLLER = 'controller';

    /**
     *
     */
    const CONTROLLER_ERROR = 'controller\error';

    /**
     *
     */
    const CONTROLLER_EXCEPTION = 'controller\exception';

    /**
     *
     */
    const COOKIES = 'cookies';

    /**
     *
     */
    const DATA = 'data';

    /**
     *
     */
    const DEFAULTS = 'defaults';

    /**
     *
     */
    const DESCRIPTION = 'description';

    /**
     *
     */
    const ERROR = 'error';

    /**
     *
     */
    const ERRORS = 'errors';

    /**
     *
     */
    const EVENT = 'event';

    /**
     *
     */
    const EVENTS = 'events';

    /**
     *
     */
    const EVENT_MODEL = 'event\model';

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
    const FILES = 'files';

    /**
     *
     */
    const FORM = 'form';

    /**
     *
     */
    const FRAGMENT = 'fragment';

    /**
     *
     */
    const HEADERS = 'headers';

    /**
     *
     */
    const HOST = 'host';

    /**
     *
     */
    const HTTP_OK = '200';

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
    const MAP = 'map';

    /**
     *
     */
    const MATCHED = 'matched';

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
     */
    const MESSAGE = 'message';

    /**
     *
     */
    const METHOD = 'method';

    /**
     *
     *
     */
    const MODEL = 'model';

    /**
     *
     */
    const NAME = 'name';

    /**
     *
     */
    const NEXT = 'next';

    /**
     *
     */
    const PARAM = 'param';

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
    const PASS = 'pass';

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
    const PORT = 'port';

    /**
     *
     */
    const PROPERTY = '$';

    /**
     *
     */
    const QUERY = 'query';

    /**
     *
     */
    const REASON = 'reason';

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
    const RESPONSE_SEND = 'response\send';

    /**
     *
     */
    const RESPONSE_STATUS = 'response\status';

    /**
     *
     */
    const RESPONSE_VERSION = 'response\version';

    /**
     *
     */
    const ROUTE = 'route';

    /**
     *
     */
    const ROUTE_DISPATCH = 'route\dispatch';

    /**
     *
     */
    const ROUTE_ERROR = 'route\error';

    /**
     *
     */
    const ROUTE_EXCEPTION = 'route\exception';

    /**
     *
     */
    const ROUTE_GENERATOR = 'route\generator';

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
    const SERVER = 'server';

    /**
     *
     */
    const SERVICE = 'service';

    /**
     *
     */
    const SERVICES = 'services';

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
    const SESSION = 'session';

    /**
     *
     */
    const STATUS = 'status';

    /**
     *
     */
    const STREAM = 'stream';

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
    const URI = 'uri';

    /**
     *
     */
    const USER = 'user';

    /**
     *
     */
    const USER_AGENT = 'user_agent';

    /**
     *
     */
    const VERSION = 'version';

    /**
     *
     */
    const VIEW_EXCEPTION = 'view\exception';

    /**
     *
     */
    const VIEW_LAYOUT = 'view\layout';

    /**
     *
     */
    const VIEW_RENDER = 'view\render';

    /**
     *
     */
    const WEB = 'web';

    /**
     *
     */
    const WILDCARD = 'wildcard';
}
