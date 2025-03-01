<?php
// Settings for web-application only -- PRODUCTION
$config = [
    'aliases' => [
        // This is for DEBUG only
        '@bower' => '@vendor/yidas/yii2-bower-asset/bower',
        '@yii/debug/assets' => '@vendor/yiisoft/yii2-debug/src/assets',
        '@yii/gii/assets' => '@vendor/yiisoft/yii2-gii',
        '@yii/assets' => '@vendor/yiisoft/yii2-gii'
    ],
    'modules' => require("_modules.php"),
    'components' => require("_components.php"),
];
if (YII_ENV_DEV) {
    // Debug Config
    $config['bootstrap'][] = 'nguyenhuukhuong';
    $config['modules']['nguyenhuukhuong'] = [
        'class' => 'yii\debug\Module',
        'historySize' => 100000,
        'allowedIPs' => [
            '127.0.0.1',
            '::1',
            '192.168.*',
            '172.18.*',
            '*'
        ],
    ];
    // Gii Config
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
        'allowedIPs' => [
            '*'
        ]
    ];
}

return $config;
