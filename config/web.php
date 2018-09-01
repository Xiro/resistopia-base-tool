<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id'         => 'basic',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log', 'ajaxLayout', 'selectData', function () {
        \Yii::$container->set('yii\bootstrap\ActiveField', [
            'inputOptions' => [
                'autocomplete' => 'off'
            ],
        ]);
    }],
    'components' => [
        'request'      => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'fEztfQrJ8KPTuDZhESSK_rq6M7IIIUnJ',
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'         => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl'        => ['user/login']
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer'       => [
            'class'            => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'ajaxLayout'   => [
            'class' => 'app\components\AjaxLayout'
        ],
        'selectData'   => [
            'class' => 'mate\yii\components\SelectData',
            'maps'  => [
                'app\models\Staff'         => [
                    'from'    => 'rpn',
                    'to'      => 'nameWithRpn',
                    'orderBy' => ['forename' => 'ASC', 'surname' => 'ASC'],
                ],
                'app\models\Rank'          => [
                    'from'    => 'id',
                    'to'      => 'name',
                    'orderBy' => ['order' => 'ASC'],
                ],
                'app\models\MissionStatus' => [
                    'from'    => 'id',
                    'to'      => 'name',
                    'orderBy' => ['id' => 'ASC'],
                ],
                'app\models\User'          => [
                    'from'    => 'id',
                    'to'      => 'identity',
                    'orderBy' => ['id' => 'ASC'],
                ],
                'default'                  => [
                    'from' => 'id',
                    'to'   => 'name'
                ],
            ]
        ],
        'db'           => $db,
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
                [
                    'pattern' => '/',
                    'route'   => 'character-registration/select',
                    'host'    => 'http://charakteranmeldung-resistopia.lost-ideas.com'
                ]
            ),
        ],
        'assetManager' => [
            'class'   => 'yii\web\AssetManager',
//            'forceCopy' => true,
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'basePath' => '@webroot',
                    'baseUrl'  => '@web',
                    'css'      => [
                        'plugins/bootstrap/bootstrap.css'
                    ],
                    'js'       => [
                        'plugins/bootstrap/bootstrap.min.js'
                    ]
                ],
            ],
        ],
    ],
    'modules' => [
        'api' => [
            'class' => 'app\api\Module'
        ]
    ],
    'params'     => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class'      => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class'      => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1'],
        'generators' => [
            'model' => [
                'class'     => 'mate\yii\generators\model\Generator',
                'templates' => [
                    'default' => '@app/vendor/mate-code/yii2-mates/src/generators/model/default',
                ]
            ],
            'crud'  => [
                'class'     => 'mate\yii\generators\crud\Generator',
                'templates' => [
                    'default'  => '@app/vendor/mate-code/yii2-mates/src/generators/crud/default',
                    'sortable' => '@app/vendor/mate-code/yii2-mates/src/generators/crud/sortable',
                    'approval' => '@app/vendor/mate-code/yii2-mates/src/generators/crud/approval',
                ]
            ],
        ]
    ];
}

return $config;
