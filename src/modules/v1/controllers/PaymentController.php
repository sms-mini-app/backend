<?php

namespace app\modules\v1\controllers;

use app\components\http\ApiConstant;
use app\controllers\Controller;
use app\helpers\QrBankHelper;
use app\modules\v1\models\Device;
use app\modules\v1\models\form\CheckoutForm;
use app\modules\v1\models\form\CheckoutFormGmail;
use app\modules\v1\models\Order;
use app\modules\v1\models\Package;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Color\Color;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Yii;
use yii\db\Exception;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use yii\web\Response;

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
        if (floatval($package->price) != $checkoutForm->getPrice()) {
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

    /**
     * @return array
     * @throws Exception
     */
    public function actionCheckoutGmail()
    {
        $checkoutForm = new CheckoutFormGmail();
        $checkoutForm->load(Yii::$app->request->post() ?: Yii::$app->request->get());
        if (!$checkoutForm->validate()) {
            Yii::info(["error" => $checkoutForm->getErrors(), "request" => Yii::$app->request->post()], "payment");
            return $this->responseBuilder->json(false, [
                "errors" => $checkoutForm->getErrors()
            ], "Invalid data", ApiConstant::STATUS_BAD_REQUEST);
        }
        $device = Device::find()->where(["tenant_id" => $checkoutForm->tenant_id])->one();
        if (!$device) {
            Yii::info(["request" => Yii::$app->request->post(), "message" => "Device not found"], "payment");
            return $this->responseBuilder->json(false, [], "Device not found", ApiConstant::STATUS_NOT_FOUND);
        }
        $package = Package::find()->andWhere(["code" => $checkoutForm->package_code])->one();
        if (!$package) {
            return $this->responseBuilder->json(false, [], "Package not found", ApiConstant::STATUS_NOT_FOUND);
        }
        if (floatval($package->price) != $checkoutForm->price) {
            Yii::info(["request" => Yii::$app->request->post(), "message" => "Price invalid"], "payment");
            return $this->responseBuilder->json(false, [], "Price invalid", ApiConstant::STATUS_BAD_REQUEST);
        }
        $order = Order::find()
            ->where(["device_id" => $device->id, "provider_code" => $checkoutForm->provider_code])
            ->one();
        if ($order) {
            return $this->responseBuilder->json(false, [], "Order exist", ApiConstant::STATUS_BAD_REQUEST);
        }
        $order = new Order([
            "device_id" => $device->id,
            "package_id" => $package->id,
            "price" => $package->price,
            "provider_code" => $checkoutForm->provider_code,
            "provider_note" => $checkoutForm->title,
            "status" => Order::STATUS_ACTIVE,
            "type" => Order::TYPE_GMAIL
        ]);

        if ($checkoutForm->is_demo) {
            $order->addUseDurationDemo();
        } else {
            $order->addUseDuration($package->use_duration);
        }
        if (!$order->save()) {
            Yii::info(["error" => $order->getErrors(), "message" => "Can't create order"], "payment");
            return $this->responseBuilder->json(false, [
                "errors" => $order->getErrors()
            ], "Can't create order", ApiConstant::STATUS_BAD_REQUEST);
        }

        return $this->responseBuilder->json(true, [], "Create order successfully");
    }

    /**
     * @throws GuzzleException
     */
    public function actionConfirmPayment()
    {
        $client = new Client(['base_uri' => env("BASE_URL_SERVICE_GMAIL")]);
        $client->post('/', [
            "json" => ["token" => "123456abcA"]
        ]);
        return $this->responseBuilder->json(true, [], "payment success");
    }

    /**
     * @param int $amount
     * @param string $accountNoName
     * @param string $note
     * @return array
     */
    public function actionGenerateQr(int $amount, string $accountNoName, string $note): array
    {
        $qrBacker = new QrBankHelper(["amount" => $amount, "accountNoName" => $accountNoName, "note" => $note]);
        return $this->responseBuilder->json(true, $qrBacker->generate(), "Success");
    }

    /**
     * @param int $amount
     * @param string $accountNoName
     * @param string $note
     * @return void
     */
    public function actionGenerateQrImage(int $amount, string $accountNoName, string $note): void
    {
        $qrBanker = new QrBankHelper(["amount" => $amount, "accountNoName" => $accountNoName, "note" => $note]);
        Yii::$app->response->format = Response::FORMAT_RAW;
        $writer = new PngWriter();
        $qrCode = QrCode::create($qrBanker->generate())
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));
        $result = $writer->write($qrCode);
        header('Content-Type: ' . $result->getMimeType());
        Yii::$app->response->data = $result->getString();
    }
}
