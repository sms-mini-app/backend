<?php

namespace app\modules\v1\controllers;

use app\modules\v1\models\search\OrderSearch;
use Yii;

class OrderController extends Controller
{
    public function actionIndex(): array
    {
        $deviceId = Yii::$app->user->getId();
        $orderSearch = new OrderSearch(["device_id" => $deviceId]);
        return $this->responseBuilder->json(false, $orderSearch->search(Yii::$app->request->queryParams), "Success");
    }
}