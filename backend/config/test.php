<?php
return [
    'id' => 'app-backend-tests',
    'components' => [
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'request' => [
            'cookieValidationKey' => 'test',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=retroverse;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock',
            'username' => 'root',  // Use 'username' aqui
            'password' => 'root',  // E 'password' aqui
            'charset' => 'utf8',
        ],
    ],
];
