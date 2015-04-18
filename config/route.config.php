<?php
return  [
    'console' => [
        'router' => [
            'routes' => [
                // Console routes go here
                'console-model-create' => [
                    'options' => [
                        'route'     => 'create module [--verbose|-v] <name> [<path>]',
                        'defaults'  => [
                            'controller'    => 'Matryoshka\Scafolding\Console\Model',
                            'action'        => 'create-module',
                        ]
                    ]
                ]
            ]
        ]
    ]
];