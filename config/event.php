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
    'route\dispatch' => [
        'route\filter',
        'router',
        'route\error'
    ],
    'route\error' => [
        'error\status',
        'error\route',
        // halt mvc event or new response object
        //'error\controller',
        //'error\view',
        //'error\response'
    ],
    'route\exception' => [
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
        //'exception\response'
    ],
    'view\render' => [
        'view\renderer'
    ],
    'web' => [
        'mvc',
        'response\send'
    ]
];
