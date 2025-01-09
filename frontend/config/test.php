<?php
return [
    'id' => 'app-frontend-tests',
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
        'mailer' => [
            'messageClass' => \yii\symfonymailer\Message::class
        ],
        'db' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=127.0.0.1;dbname=retroverse',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
    ],

    ],
];
