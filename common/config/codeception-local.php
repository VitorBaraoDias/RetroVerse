<?php

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/main.php',
    require __DIR__ . '/main-local.php',
    require __DIR__ . '/test.php',
    require __DIR__ . '/test-local.php',
    [
        'components' => [
            'request' => [
                // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
                'cookieValidationKey' => 'Gr8-9G8ZVIzBHfZ3v90LI1cgUUcopSTy',
            ],
            'db' => [
                'class' => \yii\db\Connection::class,
                'dsn' => 'mysql:host=localhost;dbname=retroverse',
                'username' => 'root',
                'password' => 'root',
                'charset' => 'utf8',
            ],
        ],
    ]
);
