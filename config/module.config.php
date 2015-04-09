<?php
$config = [
    'controllers' => [
        'invokables' => [
            'Matryoshka\Scafolding\Console\Model' => 'Matryoshka\Scafolding\Console\ModelController',
        ],
    ],
];
// Add route config
$route = include __DIR__ . '/route.config.php';
$config = \Zend\Stdlib\ArrayUtils::merge($config, $route);

return $config;
