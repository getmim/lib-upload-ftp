<?php

return [
    '__name' => 'lib-upload-ftp',
    '__version' => '0.0.3',
    '__git' => 'git@github.com:getmim/lib-upload-ftp.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/lib-upload-ftp' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'lib-upload' => NULL
            ],
            [
                'lib-ftp' => NULL
            ],
            [
                'lib-model' => NULL
            ]
        ],
        'optional' => [
            [
                'lib-ftp-ssh' => NULL
            ],
            [
                'lib-media' => NULL
            ]
        ]
    ],
    'autoload' => [
        'classes' => [
            'LibUploadFtp\\Handler' => [
                'type' => 'file',
                'base' => 'modules/lib-upload-ftp/handler'
            ],
            'LibUploadFtp\\Keeper' => [
                'type' => 'file',
                'base' => 'modules/lib-upload-ftp/keeper'
            ]
        ],
        'files' => []
    ],
    'libUpload' => [
        'keeper' => [
            'handlers' => [
                'ftp' => [
                    'class' => 'LibUploadFtp\\Keeper\\Ftp',
                    'use' => TRUE
                ]
            ]
        ]
    ],
    'libUploadFtp' => [
        'base' => '',
        'host' => NULL,
        'connection' => []
    ],
    'libMedia' => [
        'handlers' => [
            'aws' => 'LibUploadFtp\\Handler\\Ftp'
        ]
    ]
];