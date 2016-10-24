<?php
/**
 *
 */

return [
    'exception\response' => [
        'exception\log',
        'exception\error',
        'exception\controller',
        'view\render',
        'response\status',
        'response\version',
        'response\send'
    ],
    'route\match' => [
        'route\match\scheme',
        'route\match\host',
        'route\match\method',
        'route\match\path',
        'route\match\action',
        'route\match\controller',
        'route\match\wildcard'
    ],
    'service\resolver' => [
        'resolver\exception'
    ],
    'web' => [
        'route\dispatch',
        'request\error',
        'request\service',
        'controller\action',
        'view\layout',
        'view\render',
        'response\status',
        'response\version',
        'response\send'
    ],
];
