<?php

namespace app\modules\v1\controllers;

use app\components\http\ApiConstant;
use app\modules\v1\models\Package;
use app\modules\v1\models\search\PackageSearch;
use Yii;

class PackageController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new PackageSearch();

        return $this->responseBuilder->json(true, $dataProvider->search(Yii::$app->request->queryParams), "Success");
    }

    public function actionView($id, $is_show_qr_code = 0)
    {
        $package = Package::find()->where(["id" => $id])->active()->typeNormal()->one();
        if ($package) {
            $package->isShowQrCode = $is_show_qr_code;
            return $this->responseBuilder->json(true, ["package" => $package], "Success");
        }
        return $this->responseBuilder->json(false, [], "Package not found", ApiConstant::STATUS_NOT_FOUND);
    }
}
