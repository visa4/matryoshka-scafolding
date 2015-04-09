<?php
return [
    'modules' => [
        'Matryoshka\Scafolding',
    ],
    'module_listener_options' => [
        'module_paths' => [
            'Matryoshka\Scafolding' => realpath(__DIR__ . '/../'),
            './vendor',
        ],
    ]
];