<?php

namespace app\modules\v1\models;

use app\models\Order as BaseOrder;

class Order extends BaseOrder
{

    const STATUS_ACTIVE = 1;

    public function fields()
    {
        return [
            "created_at",
            "expired_at",
            "type",
            "provider_code"
        ];
    }

    public function addUseDuration($duration): void
    {
        $this->expired_at = date("Y-m-d H:i:s", time() + $duration);
    }
}