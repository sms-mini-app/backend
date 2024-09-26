<?php

namespace app\modules\v1\controllers;

use app\components\http\ApiConstant;
use app\models\DeviceToken;
use app\models\Order;
use app\modules\v1\models\form\DeviceForm;
use app\modules\v1\models\form\UpdateTenantForm;
use Yii;
use yii\db\Exception;
use yii\filters\auth\HttpBearerAuth;

class DeviceController extends Controller
{
    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            "auth" => [
                'class' => HttpBearerAuth::class,
                'except' => ["register"]
            ],
        ]);
    }

    /**
     * @return array
     */
    public function actionCheckDevice()
    {
        $device = DeviceForm::find()->where(["id" => Yii::$app->user->getId()])->one();
        if (!$device) {
            return $this->responseBuilder->json(false, $device, "Device not found", ApiConstant::STATUS_NOT_FOUND);
        }
        return $this->responseBuilder->json(true, $device, "Success");
    }

    /**
     * @return array
     */
    public function actionUpdateTenant()
    {
        $updateTenant = UpdateTenantForm::find()->where(["id" => Yii::$app->user->getId()])->one();
        $updateTenant->load(Yii::$app->request->post());
        if ($updateTenant->validate() && $updateTenant->save()) {
            return $this->responseBuilder->json(true, [], "Update tenant successfully");
        }
        return $this->responseBuilder->json(false, ["errors" => $updateTenant->getErrors()], "Can't update tenant", ApiConstant::STATUS_BAD_REQUEST);
    }

    /**
     * @return array
     * @throws Exception
     * @throws \Exception
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
        $deviceToken = DeviceToken::find()->where(["device_id" => $device->id])->available()->one();
        if (!$deviceToken) {
            $deviceToken = new DeviceToken();
            $deviceToken->generateToken($device->id);
            $deviceToken->save(false);
        }
        return $this->responseBuilder->json(true, ["device" => $device, "token" => $deviceToken->token], "Success");
    }
}