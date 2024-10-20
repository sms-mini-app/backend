<?php

namespace app\models;


/**
 * This is the ActiveQuery class for [[App]].
 *
 * @see App
 * @method App[] all($db = null)
 * @method App one($db = null)
 */
class AppQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(["status" => App::STATUS_ACTIVE]);
    }
}
