<?php
/**
 *
 */

return [
    'route\match' => [
        'route\match\merge',
        'route\match\scheme',
        'route\match\host',
        'route\match\path',
        'route\match\method',
        'route\match\csrf\token',
        'route\match\action',
        'route\match\controller',
        'route\match\middleware',
        'route\match\wildcard',
        'route\match\authenticate'
    ],
    'web' => [
        //'web\context',
        'web\route',
        'web\error',
        'web\service',
        'web\controller',
        'web\layout',
        'web\render',
        'web\status',
        'web\version',
        'web\send',
    ]
];
