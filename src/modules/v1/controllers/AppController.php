<?php

namespace app\modules\v1\controllers;

use app\models\App;

class AppController extends Controller
{
    public function actionIndex()
    {
        $apps = App::find()->active()->all();
        return $this->responseBuilder->json(true, ["apps" => $apps]);
    }
}