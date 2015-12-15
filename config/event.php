<?php
/**
 *
 */

return [
    'controller\exception' => [
        'exception\status',
        'exception\controller',
        'exception\view',
        'exception\response'
    ],
    'mvc' => [
        'mvc\route',
        'mvc\controller',
        'mvc\layout',
        'mvc\view',
        'mvc\response'
    ],
    'response\exception' => [
        'exception\status',
        'exception\controller',
        'exception\view',
        'exception\response',
        'response\send'
    ],
    'response\send' => [
        'response\send\send'
    ],
    'route\dispatch' => [
        'route\filter',
        'router',
        'route\error'
    ],
    'route\error' => [
         /**
          * The Mvc event uses a shared response object. However, a new response object can be configured, rendered and
          * returned. Returning the response object will halt the Mvc event.
          */
        'error\status',
        'error\route',
        //'error\controller',
        //'error\view',
        //'error\response'
    ],
    'route\exception' => [
         /**
          * Returns a route object that specifies the controller to use within the Mvc event. A new response object
          * can be configured, rendered and returned to halt the Mvc event.
          */
        'exception\status',
        'exception\route',
        //'exception\controller',
        //'exception\view',
        //'exception\response'
    ],
    'route\match' => [
        'route\match\scheme',
        'route\match\hostname',
        'route\match\path',
        'route\match\wildcard',
        'route\match\method'
    ],
    'service\resolver' => [
        'resolver\exception'
    ],
    'view\exception' => [
        'exception\status',
        'exception\controller',
        'exception\view',
        'exception\response'
    ],
    'view\render' => [
        'view\renderer'
    ],
    'web' => [
        'mvc',
        'response\send'
    ]
];
