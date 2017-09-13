<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'ajaxLayout'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'fEztfQrJ8KPTuDZhESSK_rq6M7IIIUnJ',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'ajaxLayout' => [
            'class' => 'app\components\AjaxLayout'
        ],
        'db' => $db,
        'urlManager'   => [
            'class'           => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName'  => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'rules'           => array(
                '<controller:\w+>/<id:\d+>'              => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'          => '<controller>/<action>',
            ),
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'forceCopy' => true,
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'css' => [
                        'plugins/bootstrap/bootstrap.css'
                    ],
                    'js' => [
                        'plugins/bootstrap/bootstrap.min.js'
                    ]
                ],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1'],
        'generators' => [
            'model' => [
                'class'     => 'yii\gii\generators\model\Generator',
                'templates' => [
                    'default' => '@app/templates/gii/model/default',
                ]
            ],
            'crud'  => [
                'class'     => 'app\templates\gii\crud\Generator',
                'templates' => [
                    'default'           => '@app/templates/gii/crud/default',
                    'sortable'          => '@app/templates/gii/crud/sortable',
                ]
            ],
        ]
    ];
}

return $config;
