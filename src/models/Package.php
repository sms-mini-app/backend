<?php

namespace app\models;

use \app\models\base\Package as BasePackage;

/**
 * This is the model class for table "packages".
 */
class Package extends BasePackage
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETE = 99;
    const TYPE_SYSTEM = 2;
    const TYPE_NORMAL = 1;

}
