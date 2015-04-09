<?php
chdir(dirname(__DIR__));

// Setup autoloading
require 'vendor/autoload.php';

$appConfig = include 'config/console.config.php';

// Run the application!
Zend\Mvc\Application::init($appConfig)->run();