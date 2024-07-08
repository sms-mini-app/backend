<?php

namespace app\models;

use DeviceToken;

/**
 * This is the ActiveQuery class for [[DeviceToken]].
 *
 * @see DeviceToken
 * @method DeviceToken[] all($db = null)
 * @method DeviceToken one($db = null)
 */
class DeviceTokenQuery extends \yii\db\ActiveQuery
{
    public function available()
    {
        return $this->andWhere(['>', 'expire_at', strtotime('now')]);
    }
}
