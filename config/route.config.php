<?php
return  [
    'console' => [
        'router' => [
            'routes' => [
                // Console routes go here
                'console-model-create' => [
                    'options' => [
                        'route'     => 'create model <name> [<path>] [--verbose|-v]',
                        'defaults'  => [
                            'controller'    => 'Matryoshka\Scafolding\Console\Module',
                            'action'        => 'create-model',
                        ]
                    ]
                ]
            ]
        ]
    ]
];