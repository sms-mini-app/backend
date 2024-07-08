<?php

namespace app\models;

use \app\models\base\DeviceToken as BaseDeviceToken;
use Exception;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "device_tokens".
 */
class DeviceToken extends BaseDeviceToken
{
    public $tokenExpiration = 60 * 24 * 365; // in seconds

    public $otpExpiration = 5 * 60;
    public $defaultAccessGiven = '{"access":["all"]}';
    const TYPE_ACTIVATION = 'activation';
    const TYPE_PASSWORD_RESET = 'password_reset';
    const TYPE_LOGIN_PASS = 'login_pass';
    const TYPE_AUTHENTICATION = "auth";
    const TYPE_OTP = "otp";
    const TOKEN_LENGTH = 40;
    public $defaultConsumer = 'web';

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => TimestampBehavior::class,
                'value' => date("Y-m-d H:i:s"),
            ]
        ]);
    }


    /**
     * @throws Exception
     */
    public function generateToken($device_id): string
    {
        $token = Yii::$app->security->generateRandomString(self::TOKEN_LENGTH);
        $this->device_id = $device_id;
        $this->type = $this->type ?? $this->defaultConsumer;
        $this->token = $token;
        $this->expire_at = $this->tokenExpiration + time();
        $this->save(false);
        return $token;
    }

}
