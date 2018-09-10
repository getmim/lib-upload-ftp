<?php

return [
    'LibUploadFtp\\Model\\MediaFtp' => [
        'indexes' => [
            'by_path' => [
                'fields' => [
                    'path' => []
                ]
            ]
        ],
        'fields' => [
            'id' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => true,
                    'primary_key' => true,
                    'auto_increment' => true
                ]
            ],
            'path' => [
                'type' => 'VARCHAR',
                'length' => 300,
                'attrs' => [
                    'null' => false
                ]
            ],
            'width' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => true
                ]
            ],
            'height' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => true
                ]
            ],
            'compression' => [
                'type' => 'VARCHAR',
                'length' => 10,
                'attrs' => [
                    'null' => false
                ]
            ],
            'created' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP',
                    'update'  => 'CURRENT_TIMESTAMP'
                ]
            ]
        ]
    ]
];