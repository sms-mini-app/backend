<?php

namespace app\modules\v1\controllers;

use app\controllers\Controller;
use app\models\KeyStorage;
use Exception;

class KeyStorageController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionIndex(): array
    {
        $keyStorages = KeyStorage::find()->select("value")->indexBy("key")->column();
        return $this->responseBuilder->json(true, $keyStorages, "Success");
    }
}