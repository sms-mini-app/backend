<?php

namespace app\modules\v2\controllers;

use app\controllers\Controller as BaseController;
use yii\filters\auth\HttpBearerAuth;

class Controller extends BaseController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
//            "auth" => [
//                'class' => HttpBearerAuth::class
//            ],
        ]);
    }
}