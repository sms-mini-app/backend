<?php

namespace app\models;

use \app\models\base\Order as BaseOrder;

/**
 * This is the model class for table "orders".
 */
class Order extends BaseOrder
{
    const TYPE_MOMO = "momo";
    const TYPE_GMAIL = "gmail";


    public function appendFieldDataDuration(): array
    {
        $timestampOfDay = 60 * 60 * 24 * 5;
        $timestampExpired = strtotime($this->expired_at);
        $timestampLeft = $timestampExpired - time();
        if ($timestampLeft <= 0) {
            $result = [
                "type" => OrderUseDuration::TYPE_EXPIRED,
                "color" => OrderUseDuration::COLOR_TYPE_EXPIRED,
            ];
        } else if ($timestampLeft <= $timestampOfDay) {
            $result = [
                "type" => OrderUseDuration::TYPE_WARNING,
                "color" => OrderUseDuration::COLOR_TYPE_WARNING,
            ];
        } else {
            $result = [
                "type" => OrderUseDuration::TYPE_AVAILABLE,
                "color" => OrderUseDuration::COLOR_TYPE_AVAILABLE,
            ];
        }
        return [
            "data_use_duration" => function () use ($result) {
                return $result;
            }
        ];
    }
}
