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
                        'GET user/{userid}' => 'userartigos',
                        'GET filtro' => 'filtro',
                        'PUT {id}/editar' => 'editarartigo',
                        'POST' => 'criarartigo',
                    ], 'tokens' => [
                    '{id}' => '<id:\\d+>',
                    '{userid}' => '<userid:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/marca',
                    'extraPatterns' => [
                        'GET' => 'marcasativas'
                    ],
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
                        'GET' => 'user',
                        'POST' => 'createcarrinho',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/linhacarrinho',
                    'extraPatterns' => [
                        'DELETE {idartigo}' => 'deletelinhacarrinho'
                    ], 'tokens' => [
                    '{id}' => '<id:\\d+>',
                    '{idartigo}' => '<idartigo:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/venda',
                    'extraPatterns' => [
                        'POST efetuarcompra' => 'comprar',
                        'GET detalhes/{id}' => 'detalhesvenda',
                        'GET compras' => 'historicocompras', //historico de compras do user x
                        'GET historico/{id}' => 'historicovendas',  //historico de vendas do user x
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/tamanho',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/tipopagamento',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/metodoexpedicao',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/categoriaartigo',
                    'extraPatterns' => [
                        'GET' => 'categoriasativas'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/favorito',
                    'extraPatterns' => [
                        'GET ' => 'favoritos',
                        'POST' => 'createfavorito',
                        'DELETE {id}' => 'deletefavorito'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/perfil',
                    'extraPatterns' => [
                        'GET' => 'verperfiluser',
                        'PUT editar' => 'editarperfil',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/avaliacao',
                    'extraPatterns' => [
                        'GET user/{id}'  => 'avaliacoesuser',
                        'POST' => 'criaravaliacao'
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
