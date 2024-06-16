<?php


$routeRules = require('_routes.php');
$components = [
    'errorHandler' => [
        'errorAction' => 'site/error',
    ],
    'user' => [
        'identityClass' => 'app\models\UserIdentity',
        'enableAutoLogin' => true,
    ],
    'cache' => require("_cache.php"),
    'request' => [
        'parsers' => [
            'application/json' => 'yii\web\JsonParser',
        ],
        'enableCsrfCookie' => false,
        'enableCookieValidation' => false,
    ],
    // using DB
    'db' => require('_db.php'),
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'enableStrictParsing' => false,
        // Comment Below if you only using UrlManager.
        'rules' => $routeRules['rules'],
    ]
];
return $components;
