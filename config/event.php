<?php
/**
 *
 */

return [
    'route\dispatch' => [
        'route\router',
        'request\error',
        'request\service',
    ],
    'response\exception' => [
        'exception\error',
        'exception\controller',
        'view\render',
        'response\model',
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
        'route\match\wildcard'
    ],
    'service\resolver' => [
        'resolver\exception'
    ],
    'web' => [
        'route\dispatch',
        'controller\action',
        'view\layout',
        'view\render',
        'response\model',
        'response\status',
        'response\version',
        'response\send'
    ],
];
