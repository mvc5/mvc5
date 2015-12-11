<?php
/**
 *
 */

return [
    'controller\dispatch' => [
        'controller\action'
    ],
    'controller\exception' => [
        'exception\status',
        'exception\controller'
    ],
    'mvc' => [
        'mvc\route',
        'mvc\controller',
        'mvc\layout',
        'mvc\view',
        'mvc\response'
    ],
    'response\dispatch' => [
        'response\send'
    ],
    'response\exception' => [
        'exception\status',
        'exception\controller',
        'exception\view',
    ],
    'route\dispatch' => [
        'route\filter',
        'router',
        'route\error'
    ],
    'route\error\dispatch' => [
        'route\error\status',
        'route\error\controller'
    ],
    'route\exception' => [
        'exception\status',
        'exception\route',
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
    ],
    'view\render' => [
        'view\renderer'
    ],
];
