<?php

use app\bootstrap\QueueEventBootstrap;

$config = [
    'id' => 'console',
    'basePath' => dirname(__DIR__, 2) . "/src",
    'controllerNamespace' => 'app\commands',
    'aliases' => require_once("_aliases.php"),
    'components' => [
        'db' => require('_db.php'),
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => yii\console\controllers\MigrateController::class,
            'migrationPath' => '@app/migrations/db',
            'migrationTable' => '{{%system_db_migration}}'
        ],
        'batch' => [
            'class' => 'schmunk42\giiant\commands\BatchController',
            'interactive' => false,
            'overwrite' => true,
            'skipTables' => ['system_db_migration', 'system_rbac_migration', 'queues', 'queues_mqtt', 'queues_build'],
            'modelNamespace' => 'app\models',
            'crudTidyOutput' => false,
            'useTranslatableBehavior' => true,
            'useTimestampBehavior' => true,
            'enableI18N' => false,
            'modelQueryNamespace' => 'app\models',
            'modelBaseClass' => yii\db\ActiveRecord::className(),
            'modelQueryBaseClass' => yii\db\ActiveQuery::className()
        ],
    ]
];
if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
        'allowedIPs' => [
            '*'
        ]
    ];
}
return $config;