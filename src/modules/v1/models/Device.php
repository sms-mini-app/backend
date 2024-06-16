<?php

namespace app\modules\v1\models;

use app\models\Device as BaseDevice;
use yii\db\ActiveQuery;

class Device extends BaseDevice
{
    public function fields()
    {
        return [
            "id",
            "tenant_id",
            "logged_at",
            "orders"
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getPackages(): ActiveQuery
    {
        return $this->hasMany(Package::class, ["id" => "package_id"])->via("orders");
    }

    /**
     * @return ActiveQuery
     */
    public function getOrders(): ActiveQuery
    {
        return $this->hasMany(Order::class, ["device_id" => "id"])->andWhere([
            "AND",
            [">=", "expired_at", date("Y-m-d H:i:s")],
            ["status" => true]
        ]);
    }
}