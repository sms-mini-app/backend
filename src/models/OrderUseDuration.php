<?php

namespace app\models;

use yii\base\Model;

class OrderUseDuration extends Model
{
    const COLOR_TYPE_AVAILABLE = "#2ecc71";
    const COLOR_TYPE_WARNING = "#ffc107";
    const COLOR_TYPE_EXPIRED = "#e74a3b";

    const TYPE_AVAILABLE = 1;
    const TYPE_WARNING = 2;
    const TYPE_EXPIRED = 3;
}
