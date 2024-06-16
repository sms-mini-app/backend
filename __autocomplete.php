<?php

use app\components\cloudflare\CloudFlarePage;
use app\components\cloudflare\KvStorageClient;
use app\components\insight\InsightComponent;
use app\components\screenshot\ScreenshotComponent;
use app\components\storage\Storage;
use app\components\web_portal\plugin\PluginStore;
use yii\queue\redis\Queue;
use yii\redis\Connection;

class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication the application instance
     */
    public static $app;
}

/**
 * @property app\components\web_portal\Component $web_portal
 * @property app\components\web_portal\Component $web_portal_custom
 * @property Queue $queue
 * @property Queue $queue_sync
 * @property Queue $queue_mqtt
 * @property Queue $queue_build
 * @property app\models\UserIdentity $user
 * @property app\components\web_portal\log\ $log_project
 * @property app\components\mqtt\MqttClient $mqtt
 * @property CloudFlarePage $cloudflare_page
 * @property ScreenshotComponent $screenshot
 * @property Storage $storage
 * @property KvStorageClient $cloudflare_kv
 * @property InsightComponent $insight
 * @property Connection $redis
 */
abstract class BaseApplication extends yii\base\Application
{
    /**
     * @var User
     */
    public $user;
}

/**
 * @property app\models\UserIdentity $identity
 */
abstract class User extends \yii\web\User
{
}
