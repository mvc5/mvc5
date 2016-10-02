<?php
/**
 * Strict mode does not change the case of the controller or action name. However, most urls are lower case and file
 * names and directories typically begin with an uppercase letter. This means the controllers can not be automatically
 * auto-loaded. This can be resolved by using a service loader and having a service configuration with a matching
 * lower case name. The service configuration will then specify the name of the class to be auto-loaded.
 *
 * E.g 'home\controller' => Home\Controller::class
 */

return [
    'defaults'    => ['controller' => 'home'],
    'constraints' => ['controller' => '[a-zA-Z0-9_-]+', 'action' => '[a-zA-Z0-9_-]+'],
    'name'        => 'app',
    'options'     => [
        'prefix'     => '',
        'separators' => ['-' => '\\', '_' => '_'],
        'split'      => '\\',
        'strict'     => true,
        'suffix'     => '\controller'
    ],
    'paramMap'    => ['param1' => 'controller', 'param2' => 'action'],
    'route'       => '/[:controller[/:action]]'
];
