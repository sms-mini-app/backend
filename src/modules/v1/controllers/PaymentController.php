<?php

namespace app\modules\v1\controllers;

use app\components\http\ApiConstant;
use app\controllers\Controller;
use app\modules\v1\models\Device;
use app\modules\v1\models\form\CheckoutForm;
use app\modules\v1\models\Order;
use app\modules\v1\models\Package;
use Yii;

class PaymentController extends Controller
{
    public function actionCheckout()
    {
        $checkoutForm = new CheckoutForm();

        $checkoutForm->load(Yii::$app->request->post());
        if (!$checkoutForm->validate()) {
            Yii::info(["error" => $checkoutForm->getErrors(), "request" => Yii::$app->request->post()], "payment");
            return $this->responseBuilder->json(false, [
                "errors" => $checkoutForm->getErrors()
            ], "Invalid data", ApiConstant::STATUS_BAD_REQUEST);
        }

        $device = Device::find()->where(["tenant_id" => $checkoutForm->getTenantId()])->one();
        if (!$device) {
            Yii::info(["request" => Yii::$app->request->post(), "message" => "Device not found"], "payment");
            return $this->responseBuilder->json(false, [], "Device not found", ApiConstant::STATUS_NOT_FOUND);
        }
        $package = Package::find()->one();
        if (floatval($package->price) !== $checkoutForm->getPrice()) {
            Yii::info(["request" => Yii::$app->request->post(), "message" => "Price invalid"], "payment");
            return $this->responseBuilder->json(false, [], "Price invalid", ApiConstant::STATUS_BAD_REQUEST);
        }
        $order = new Order([
            "device_id" => $device->id,
            "package_id" => $package->id,
            "price" => $package->price,
            "customer" => $checkoutForm->title,
            "provider_note" => $checkoutForm->provider_note,
            "status" => Order::STATUS_ACTIVE,
            "type" => $checkoutForm->name
        ]);

        $order->addUseDuration($package->use_duration);
        if (!$order->save()) {
            Yii::info(["error" => $order->getErrors(), "message" => "Can't create order"], "payment");
            return $this->responseBuilder->json(false, [
                "errors" => $order->getErrors()
            ], "Can't create order", ApiConstant::STATUS_BAD_REQUEST);
        }

        return $this->responseBuilder->json(true, [], "Create order successfully");

    }
}