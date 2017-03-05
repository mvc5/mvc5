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
    'log' => [
        'log\exception',
        'log\error'
    ],
    'service\resolver' => [
        'resolver\exception'
    ],
    'web' => [
        //'service\context',
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
