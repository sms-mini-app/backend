<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Package]].
 *
 * @see Package
 * @method Package[] all($db = null)
 * @method Package one($db = null)
 */
class PackageQuery extends \yii\db\ActiveQuery
{

    public function active()
    {
        return $this->andWhere(["status" => Package::STATUS_ACTIVE]);
    }

    public function typeNormal()
    {
        return $this->andWhere(["type" => Package::TYPE_NORMAL]);
    }

}
