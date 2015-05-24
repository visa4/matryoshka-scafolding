<?php
$config = [
    'service_manager' => [
        'invokables' => [
            'Matryoshka\Scafolding\Service\Skeleton\Skeleton' => 'Matryoshka\Scafolding\Service\Skeleton\Skeleton',
            'Matryoshka\Scafolding\Service\Entity' => 'Matryoshka\Scafolding\Service\Entity',
            'Matryoshka\Scafolding\Service\Model\Model' => 'Matryoshka\Scafolding\Service\Model\Model',
            'Matryoshka\Scafolding\Service\Model\Adapter\MongoAdapter' => 'Matryoshka\Scafolding\Service\Model\Adapter\MongoAdapter',
            'Matryoshka\Scafolding\Service\Model\Adapter\Connection\MongoConnectionAdapter' => 'Matryoshka\Scafolding\Service\Model\Adapter\Connection\MongoConnectionAdapter',
        ],
        'factories' => [
            'Matryoshka\Scafolding\Service\Hydrator\Hydrator' => 'Matryoshka\Scafolding\Service\Hydrator\HydratorFactory',
            'Matryoshka\Scafolding\Service\Config\Config' => 'Matryoshka\Scafolding\Service\Config\ConfigFactory',
        ],
        'aliases' => [
            'Model\Adapter\MongoAdapter' => 'Matryoshka\Scafolding\Service\Model\Adapter\MongoAdapter',
            'Model\Adapter\Connection\MongoConnectionAdapter' => 'Matryoshka\Scafolding\Service\Model\Adapter\Connection\MongoConnectionAdapter',
        ]
    ],
    'controllers' => [
        'invokables' => [
            'Matryoshka\Scafolding\Console\Module' => 'Matryoshka\Scafolding\Console\ModuleController',
        ],
    ],
];
// Add route config
$route = include __DIR__ . '/route.config.php';
$config = \Zend\Stdlib\ArrayUtils::merge($config, $route);

return $config;
