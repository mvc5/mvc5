<?php
/**
 *
 */

return [
    'Controller\Dispatch' => [
        'Controller\Dispatcher'
    ],
    'Controller\Exception' => [
        'Controller\Exception\Controller'
    ],
    'Exception\View' => [
        'Exception\Renderer'
    ],
    'Mvc' => [
        'Mvc\Route',
        'Mvc\Controller',
        'Mvc\Layout',
        'Mvc\View',
        'Mvc\Response'
    ],
    'Response\Dispatch' => [
        'Response\Sender'
    ],
    'Response\Exception' => [
        'Response\Exception\Dispatch',
        'Response\Exception\Renderer'
    ],
    'Route\Match' => [
        'Route\Match\Scheme',
        'Route\Match\Hostname',
        'Route\Match\Path',
        'Route\Match\Wildcard',
        'Route\Match\Method'
    ],
    'Route\Dispatch' => [
        'Route\Filter',
        'Router',
        'Route\Error'
    ],
    'Route\Exception' => [
        'Route\Exception\Controller'
    ],
    'Service\Provider' => [
        'Service\DefaultResolver'
    ],
    'View\Render' => [
        'View\Renderer'
    ],
];
