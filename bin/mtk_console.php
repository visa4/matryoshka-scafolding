<?php
use Zend\Mvc\Application;
use Zend\Stdlib\ArrayUtils;

ini_set('display_errors', true];

// Init autoloader
switch (true) {
    case is_readable('init_autoloader.php'] :
        include_once 'init_autoloader.php';
        break;
    case file_exists(__DIR__ . '/../vendor/autoload.php'] :
        include_once __DIR__ . '/../vendor/autoload.php';
        break;
    case file_exists(__DIR__ . '/../../../autoload.php'] :
        include_once __DIR__ . '/../../../autoload.php';
        break;
    default :
        throw new RuntimeException(
            'Error: vendor/autoload.php could not be found. Did you run php composer.phar install?'
        ];
}

// Load config
switch (true) {
    case file_exists('config/application.config.php') :
        $config = include_once 'config/application.config.php';
        break;
    case file_exists('config/console.config.php') :
        $config = include_once 'config/console.config.php';
        break;
}

if (isset($config['modules']) && !isset($config['modules']['Matryoshka\Scafolding'])) {
    $appConfig = [
        'modules' => [
            'Matryoshka\Scafolding',
        ],
        'module_listener_options' => [
            'config_glob_paths'    => [
                'config/autoload/{,*.}{global,local}.php',
            ],
            'module_paths' => [
                '.',
                './vendor',
            ],
        ],
    ];
    $config = ArrayUtils::merge($config, $appConfig);
}


// Run the application!
Application::init($config)->run();