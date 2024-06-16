<?php
$rootPath = __DIR__.'/..';

require($rootPath.'/vendor/autoload.php');
require($rootPath.'/config/env.php');

defined('YII_DEBUG') or define('YII_DEBUG', env('YII_DEBUG'));
defined('YII_ENV') or define('YII_ENV', env('YII_ENV'));

// Yii
require($rootPath . '/vendor/yiisoft/yii2/Yii.php');

// Bootstrap Application
require($rootPath . '/config/web/bootstrap.php');

$config = \yii\helpers\ArrayHelper::merge(
    require($rootPath . '/config/base.php'),
    require($rootPath . '/config/web/config.php')
);

$application = new yii\web\Application($config);
$application->run();
