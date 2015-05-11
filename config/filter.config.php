<?php
return  [
    'invokables' => [
        'Matryoshka\Scafolding\Filter\LcFirst' => 'Matryoshka\Scafolding\Filter\LcFirst',
        'Matryoshka\Scafolding\Filter\UcFirst' => 'Matryoshka\Scafolding\Filter\UcFirst',
    ],
    'aliases' => [
        'lcfirst' => 'Matryoshka\Scafolding\Filter\LcFirst',
        'ucfirst' => 'Matryoshka\Scafolding\Filter\UcFirst',
    ]
];