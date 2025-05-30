<?php

namespace app\modules\v1\models;

use app\models\Order as BaseOrder;

class Order extends BaseOrder
{

    const STATUS_ACTIVE = 1;

    public function fields()
    {
        return array_merge([
            "id",
            "price",
            "created_at" => function () {
                return strtotime($this->created_at);
            },
            "expired_at" => function () {
                return strtotime($this->expired_at);
            },
            "type",
            "provider_code",
            "package"
        ], $this->appendFieldDataDuration());
    }

    public function getPackage()
    {
        return $this->hasOne(Package::class, ["id" => "package_id"]);
    }

    public function addUseDuration($duration): void
    {
        $this->expired_at = date("Y-m-d H:i:s", time() + $duration);
    }

    public function addUseDurationDemo()
    {
        $this->expired_at = date("Y-m-d 19:00:00", time());
    }
}
