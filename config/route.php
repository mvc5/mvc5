<?php
/**
 *
 */

return [
    'name'        => 'app',
    'options'     => ['prefix' => '', 'suffix' => '\Controller', 'split' => '\\', 'separators' => ['-' => '\\', '_' => '_']],
    'route'       => '/[:controller[/:action]]',
    'defaults'    => ['controller' => 'home'],
    'constraints' => ['controller' => '[a-zA-Z0-9_-]+', 'action' => '[a-zA-Z0-9_-]+'],
    'paramMap'    => ['param1' => 'controller', 'param2' => 'action']
];
