<?php
/**
 *
 */

return [
    'controller\exception' => [
        'exception\status',
        'exception\controller',
        //'exception\view',
        //'exception\response'
    ],
    'controller\error' => [
        'error\status',
        'error\controller'
    ],
    'mvc' => [
        'mvc\route',
        'mvc\controller',
        'mvc\error',
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
    'route\dispatch' => [
        'router',
        'route\error'
    ],
    'route\error' => [
        'error\handler',
        'error\status',
        'error\request',
        // optionally halt mvc with a new response object,
        // see response\exception for example service configuration
        //'error\controller',
        //'error\layout',
        //'error\view',
        //'error\response'
    ],
    'route\exception' => [
        'exception\status',
        'exception\request',
        //'exception\controller',
        //'exception\view',
        //'exception\response'
    ],
    'route\match' => [
        'route\match\scheme',
        'route\match\host',
        'route\match\method',
        'route\match\path',
        'route\match\action',
        'route\match\wildcard'
    ],
    'service\resolver' => [
        'resolver\exception'
    ],
    'view\exception' => [
        'exception\status',
        'exception\controller',
        'exception\view',
        //'exception\response'
    ],
    'view\render' => [
        'view\renderer'
    ],
    'web' => [
        'mvc',
        'response\prepare',
        'response\send'
    ]
];
