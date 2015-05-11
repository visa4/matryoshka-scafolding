<?php
$config = [
    'service_manager' => [
        'invokables' => [
            'Matryoshka\Scafolding\Service\Skeleton' => 'Matryoshka\Scafolding\Service\Skeleton',
            'Matryoshka\Scafolding\Service\Entity' => 'Matryoshka\Scafolding\Service\Entity',
            'Matryoshka\Scafolding\Service\Model' => 'Matryoshka\Scafolding\Service\Model',
        ],
        'factories' => [
            'Matryoshka\Scafolding\Service\Hydrator\Hydrator' => 'Matryoshka\Scafolding\Service\Hydrator\HydratorFactory',
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
