<?php

namespace app\models;

use \app\models\base\Device as BaseDevice;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "devices".
 */
class Device extends BaseDevice
{
    const STATUS_ACTIVE = 1;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => TimestampBehavior::className(),
                'value' => date("Y-m-d H:i:s"),
            ]
        ]);
    }


    public function formName()
    {
        return "";
    }
}
