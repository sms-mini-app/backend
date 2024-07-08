<?php

namespace app\models;

use yii\web\IdentityInterface;

class DeviceIdentity extends Device implements IdentityInterface
{

    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
    }

    public static function findIdentityByAccessToken($token, $type = null): DeviceIdentity|IdentityInterface|null
    {
        $accessToken = DeviceToken::find()
            ->where(['token' => $token])
            ->available()
            ->one();
        if (!$accessToken) return $accessToken;
        return self::findOne(['id' => $accessToken->device_id]);
    }

    public function getId(): int|string
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}