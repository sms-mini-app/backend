<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use samdark\log\PsrTarget;
use Sentry\ClientBuilder;
use Sentry\Monolog\Handler;
use Sentry\State\Hub;

// Other Config Load
// Config for Monolog
$psrLogger = new Logger(env('APP_NAME', false), [
    new StreamHandler('php://stdout', YII_DEBUG ? Logger::DEBUG : Logger::INFO),
], [], new DateTimeZone('UTC'));
//
if (!YII_DEBUG || env("SENTRY_ACTIVE", 0) == 1) {
    if (env("SENTRY_DSN", false)) {
        $client = ClientBuilder::create(['dsn' => env("SENTRY_DSN", false)])->getClient();
        $psrLogger->pushHandler(new Handler(new Hub($client), Logger::ERROR));
    }
}

// Basic configuration, used in web and console applications
return [
    'id' => 'app',
    'language' => 'en',
    'timezone' => 'Asia/Ho_Chi_Minh',
    'basePath' => dirname(__DIR__) . '/src',
    'vendorPath' => '@app/../vendor',
    'runtimePath' => '@app/../runtime',
    'aliases' => require_once("_aliases.php"),
    // Bootstrapped modules are loaded in every request
    'bootstrap' => array_merge([
        'log',
    ]),
    'components' => array_merge([
        'log' => [
            'class' => yii\log\Dispatcher::class,
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'flushInterval' => 1,
            'targets' => [
                'psr3' => [
                    'class' => PsrTarget::class,
                    'logger' => $psrLogger,

                    // It is optional parameter. The message levels that this target is interested in.
                    // The parameter can be an array.
                    'levels' => [Psr\Log\LogLevel::ERROR],
                    // It is optional parameter. Default value is false. If you use Yii log buffering, you see buffer write time, and not real timestamp.
                    // If you want write real time to logs, you can set addTimestampToContext as true and use timestamp from log event context.
                    'addTimestampToContext' => true,
                    'logVars' => [null],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['payment'],
                    'logVars' => [null],
                ],
            ],
        ]
    ])
];
