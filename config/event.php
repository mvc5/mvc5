<?php
/**
 *
 */

return [
    'controller\response' => [
        'controller\action',
        'view\layout',
        'view\render'
    ],
    'exception\response' => [
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
        'route\match\wildcard'
    ],
    'service\resolver' => [
        'resolver\exception'
    ],
    'web' => [
        'route\dispatch',
        'request\error',
        'request\service',
        'controller\dispatch',
        'response\status',
        'response\version',
        'response\send'
    ],
];
