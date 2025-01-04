<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\ModuleAPI',
        ],
    ],
    'components' => [
        'assetManager' => [
            'bundles' => [
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => false // do not load bootstrap assets for a specific asset bundle
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    'backend/views' => '@vendor/hail812/yii2-adminlte3/src/views'
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/artigo',
                    'extraPatterns' => [
                    'GET {id}' => 'artigodetalhes',
                    'GET {tipoartigo}/{tamanho}/{marca}/{estado}' => 'artigofiltro',
                    'GET {tipoartigo}/{tamanho}/{marca}' => 'artigofiltro',
                    'GET {tipoartigo}/{tamanho}' => 'artigofiltro',
                    'GET {tipoartigo}' => 'artigofiltro',
                    'GET ' => 'artigofiltro',
                ], 'tokens' => [
                        '{id}' => '<id:\\d+>',
                        '{tipoartigo}' => '<tipoartigo:\\w+>',
                        '{tamanho}' => '<tamanho:\\w+>',
                        '{marca}' => '<marca:\\w+>',
                        '{estado}' => '<estado:\\w+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/marca',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/estado',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/user',
                    'extraPatterns' => [
                        'POST ' => 'usercreate',
                        'POST login' => 'login',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/carrinho',
                    'extraPatterns' => [
                        'GET user/{id}' => 'user',
                        'POST' => 'create'

                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/venda',
                    'extraPatterns' => [
                        'POST comprar' => 'comprar',
                        'GET detalhes/{id}' => 'detalhesvenda',
                        'GET compras/{id}' => 'historicocompras',
                        'GET {id}' => 'historicovendas',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/tamanho',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/categoriaartigo',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/favorito',
                    'extraPatterns' => [
                        'GET user/{id}' => 'user'

                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/chat',
                    'extraPatterns' => [
                        'GET conversas/{idchat}' => 'conversas',
                        'GET listachats/{iduser}' => 'listachats',
                        'POST' => 'create'

                    ],
                    'tokens' => [
                        '{idchat}' => '<idchat:\\d+>',
                        '{iduser}' => '<iduser:\\d+>',

                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
