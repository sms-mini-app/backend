<?php

use app\components\cloudflare\CloudFlarePage;
use app\components\cloudflare\KvStorageClient;
use app\components\insight\InsightComponent;
use app\components\screenshot\ScreenshotComponent;
use app\components\storage\Storage;
use app\components\web_portal\plugin\PluginStore;
use app\models\Device;
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
 * @property app\models\DeviceIdentity $device
 */
abstract class BaseApplication extends yii\base\Application
{
    /**
     * @var Device
     */
    public $device;
}
