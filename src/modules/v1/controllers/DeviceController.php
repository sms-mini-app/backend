<?php

namespace app\modules\v1\controllers;

use app\components\http\ApiConstant;
use app\controllers\Controller;
use app\modules\v1\models\form\DeviceForm;
use Yii;
use yii\db\Exception;

class DeviceController extends Controller
{

    /**
     * @param $device_uuid
     * @return array
     */
    public function actionCheckDevice($device_uuid): array
    {
        $deviceUuidHash = md5($device_uuid);
        $device = DeviceForm::find()->where(["device_uuid_hash" => $deviceUuidHash])->one();
        if (!$device) {
            return $this->responseBuilder->json(false, $device, "Device not found", ApiConstant::STATUS_NOT_FOUND);
        }
        return $this->responseBuilder->json(true, $device, "Success");
    }

    /**
     * @return array
     * @throws Exception
     */
    public function actionRegister(): array
    {
        $deviceUuid = Yii::$app->request->post("device_uuid");
        if (!$deviceUuid) {
            return $this->responseBuilder->json(false, [], "Mission device uuid", ApiConstant::STATUS_BAD_REQUEST);
        }
        $deviceUuidHash = md5($deviceUuid);
        $device = DeviceForm::find()->where(["device_uuid_hash" => $deviceUuidHash])->one();
        if (!$device) {
            $device = new DeviceForm(["device_uuid_hash" => $deviceUuidHash]);
            $device->load(Yii::$app->request->post());
        }
        if (!$device->validate() || !$device->save()) {
            return $this->responseBuilder->json(false, $device, "Can't register device", ApiConstant::STATUS_BAD_REQUEST);
        }
        return $this->responseBuilder->json(true, $device, "Success");
    }
}