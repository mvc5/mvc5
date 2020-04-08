<?php
/**
 *
 */

namespace Mvc5
{
    const ABSOLUTE = 'absolute';
    const ACCEPTS_JSON = 'accepts_json';
    const ACTION = 'action';
    const ARGS = 'args';
    const ARGV = 'argv';
    const ATTRIBUTES = 'attributes';
    const AUTHENTICATE = 'authenticate';
    const AUTHENTICATED = 'authenticated';
    const BODY = 'body';
    const CALL = '@';
    const CALLS = 'calls';
    const CALL_SEPARATOR = '.';
    const CHILDREN = 'children';
    const CHILD_MODEL = '__child';
    const CLASS_NAME = 'class';
    const CLIENT_ADDRESS = 'client_address';
    const CODE = 'code';
    const CONFIG = 'config';
    const CONSTRAINTS = 'constraints';
    const CONTAINER = 'container';
    const CONTEXT = 'context';
    const CONTROLLER = 'controller';
    const COOKIE_EXPIRE_TIME = 946706400;
    const COOKIES = 'cookies';
    const CSRF_TOKEN = 'csrf_token';
    const DATA = 'data';
    const DANGER = 'danger';
    const DEFAULTS = 'defaults';
    const DESCRIPTION = 'description';
    const DOMAIN = 'domain';
    const ERROR = 'error';
    const ERROR_MODEL = 'error\model';
    const ERRORS = 'errors';
    const EVENT = 'event';
    const EVENTS = 'events';
    const EVENT_MODEL = 'event\model';
    const EXCEPTION = 'exception';
    const EXCEPTION_LAYOUT = 'exception\layout';
    const EXCEPTION_RESPONSE = 'exception\response';
    const EXPIRES = 'expires';
    const FACTORY = 'factory';
    const FILE = 'file';
    const FILES = 'files';
    const FORM = 'form';
    const FRAGMENT = 'fragment';
    const HEADERS = 'headers';
    const HOST = 'host';
    const HTTP_GET = 'GET';
    const HTTP_HEAD = 'HEAD';
    const HTTP_MIDDLEWARE = 'http\middleware';
    const HTTP_OK = 200;
    const HTTP_ONLY = 'httponly';
    const HTTP_SERVER_ERROR = 500;
    const INDEX = '#';
    const INFO = 'info';
    const ITEM = 'item';
    const LAYOUT = 'layout';
    const LEVEL = 'level';
    const LINE = 'line';
    const LOG = 'log';
    const MATCHED = 'matched';
    const MAX_RECURSION = 100;
    const MERGE = 'merge';
    const MESSAGE = 'message';
    const METHOD = 'method';
    const MIDDLEWARE = 'middleware';
    const MODEL = 'model';
    const NAME = 'name';
    const OPTIONAL = 'optional';
    const OPTIONS = 'options';
    const PARAM = 'param';
    const PARAMS = 'params';
    const PARENT = 'parent';
    const PASS = 'pass';
    const PATH = 'path';
    const PLUGIN = 'plugin';
    const PORT = 'port';
    const PREFIX = 'prefix';
    const PROPERTY = '$';
    const QUERY = 'query';
    const QUERY_SEPARATOR = '&';
    const RAW = 'raw';
    const REASON = 'reason';
    const REDIRECT_URL = 'redirect_url';
    const REGEX = 'regex';
    const RENDER = 'render';
    const REQUEST = 'request';
    const RESPONSE = 'response';
    const RESPONSE_DISPATCH = 'response\dispatch';
    const RESPONSE_JSON = 'response\json';
    const RESPONSE_JSON_ERROR = 'response\json\error';
    const RESPONSE_JSON_EXCEPTION = 'response\json\exception';
    const RESPONSE_REDIRECT = 'response\redirect';
    const ROUTE = 'route';
    const SAMESITE = 'samesite';
    const SCHEME = 'scheme';
    const SECURE = 'secure';
    const SEPARATOR = '/';
    const SEPARATORS = 'separators';
    const SERVER = 'server';
    const SERVICE = 'service';
    const SERVICES = 'services';
    const SERVICE_RESOLVER = 'service\resolver';
    const SERVICE_SEPARATOR = '->';
    const SESSION = 'session';
    const SESSION_MESSAGES = 'session\messages';
    const SEVERITY_CRITICAL = 2;
    const SPLIT = 'split';
    const STATUS = 'status';
    const STRICT = 'strict';
    const SUCCESS = 'success';
    const SUFFIX = 'suffix';
    const TARGET = 'target';
    const TEMPLATE = 'template';
    const TEMPLATE_MODEL = '__template';
    const THROW_EXCEPTION = 'throw_exception';
    const TOKENS = 'tokens';
    const TRACE = 'trace';
    const TYPE = 'type';
    const URI = 'uri';
    const URL = 'url';
    const USER = 'user';
    const USERNAME = 'username';
    const USER_AGENT = 'user_agent';
    const VALUE = 'value';
    const VARS = 'vars';
    const VERSION = 'version';
    const VIEW_EXTENSION = 'phtml';
    const VIEW_MODEL = 'view\model';
    const WARNING = 'warning';
    const WEB = 'web';
    const WILDCARD = 'wildcard';
}

/**
 *
 */
namespace Mvc5\Route\Dash
{
    const CONSTRAINT = 2;
    const LITERAL = 1;
    const NAME = 1;
    const TYPE = 0;
}

/**
 *
 */
namespace Mvc5\Template
{
    use Throwable;

    use function extract;
    use function ob_end_clean;
    use function ob_get_clean;
    use function ob_get_level;
    use function ob_start;

    /**
     * @param TemplateModel $template
     * @return string
     */
    function render(TemplateModel $template): string
    {
        return (function () {
            /** @var TemplateModel $this */

            extract($this->vars(), EXTR_SKIP);

            $__ob_level__ = ob_get_level();

            ob_start();

            try {

                include $this->template();

                return ob_get_clean();

            } catch (Throwable $exception) {
                while (ob_get_level() > $__ob_level__) {
                    ob_end_clean();
                }

                throw $exception;
            }
        })->call($template);
    }
}
