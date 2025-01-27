<?php

namespace app\models;

use \app\models\base\DeviceService as BaseDeviceService;

/**
 * This is the model class for table "device_services".
 */
class DeviceService extends BaseDeviceService
{
    const SERVICE_FIREBASE = 1;

    public function formName()
    {
        return "";
    }
}
