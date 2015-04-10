<?php
use Zend\Mvc\Application;

ini_set('display_errors', true);

// Init autoloader
switch (true) {
    case is_readable('init_autoloader.php') :
        include_once 'init_autoloader.php';
        break;
    case file_exists(__DIR__ . '/../vendor/autoload.php') :
        include_once __DIR__ . '/../vendor/autoload.php';
        break;
    case file_exists(__DIR__ . '/../../../autoload.php') :
        include_once __DIR__ . '/../../../autoload.php';
        break;
    default :
        throw new RuntimeException(
            'Error: vendor/autoload.php could not be found. Did you run php composer.phar install?'
        );
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

// Run the application!
Application::init($config)->run();