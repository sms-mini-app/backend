<?php

namespace app\modules\v1\controllers;

use app\components\http\ApiConstant;
use app\models\SessionWork as SessionWorkAlias;
use app\modules\v1\models\form\SessionWorkForm;
use app\modules\v1\models\search\SessionWorkSearch;
use app\modules\v1\models\SessionWork;
use Yii;

class SessionWorkController extends Controller
{
    public function actionCreate()
    {
        $sessionIdOld = Yii::$app->request->post("data")["extras_data"]["session_id"] ?? null;
        $sessionWork = SessionWorkForm::find()->where(["id" => $sessionIdOld, "created_by" => Yii::$app->user->id])->one();
        if (!$sessionWork) {
            $sessionWork = new SessionWorkForm([
                "created_by" => Yii::$app->user->id
            ]);
        }
        $sessionWork->load(Yii::$app->request->post());
        if (!$sessionWork->validate()) {
            return $this->responseBuilder->json(false, ["error" => $sessionWork->getErrors()], "Error", ApiConstant::STATUS_BAD_REQUEST);
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $sessionWork->setAttributeByData();
            $sessionWork->setAllSessionNotUse();
            if (!$sessionWork->save()) {
                $transaction->rollBack();
                return $this->responseBuilder->json(false, ["error" => $sessionWork->getErrors()], "Error", ApiConstant::STATUS_BAD_REQUEST);
            }
            $transaction->commit();
            return $this->responseBuilder->json(true, [], "Success");
        } catch (\Exception $exception) {
            return $this->responseBuilder->json(false, ["error" => "exception"], "Error", ApiConstant::STATUS_BAD_REQUEST);
        }
    }

    public function actionIndex()
    {
        $dataProvider = new SessionWorkSearch([
            "created_by" => Yii::$app->user->id
        ]);
        return $this->responseBuilder->json(
            true,
            $dataProvider->search(Yii::$app->request->queryParams),
            "Success");
    }

    public function actionView($id)
    {
        $createdBy = Yii::$app->user->id;
        $sessionWork = SessionWork::find()->where([
            "id" => $id,
            "created_by" => $createdBy
        ])->one();

        if (!$sessionWork) {
            return $this->responseBuilder->json(false, [], "Error", ApiConstant::STATUS_NOT_FOUND);
        }
        return $this->responseBuilder->json(true, $sessionWork, "Success");
    }

    /**
     * @return array
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->post("id");
        if (!$id) {
            return $this->responseBuilder->json(false, [], "Id invalid", ApiConstant::STATUS_BAD_REQUEST);
        }
        $createdBy = Yii::$app->user->id;
        $sessionWork = SessionWork::find()->where([
            "id" => $id,
            "created_by" => $createdBy
        ])->one();

        if (!$sessionWork) {
            return $this->responseBuilder->json(false, [], "Error", ApiConstant::STATUS_NOT_FOUND);
        }

        if ($sessionWork->delete()) {
            return $this->responseBuilder->json(true, [], "Success");
        }
        return $this->responseBuilder->json(false, [], "Error", ApiConstant::STATUS_BAD_REQUEST);
    }

    public function actionRollback()
    {
        $id = Yii::$app->request->post("id");
        if (!$id) {
            return $this->responseBuilder->json(false, [], "Id invalid", ApiConstant::STATUS_BAD_REQUEST);
        }

        $createdBy = Yii::$app->user->id;
        $sessionWork = SessionWork::find()->where([
            "id" => $id,
            "created_by" => $createdBy
        ])->one();

        if (!$sessionWork) {
            return $this->responseBuilder->json(false, [], "Error", ApiConstant::STATUS_NOT_FOUND);
        }
        if ($sessionWork->is_session_current) {
            return $this->responseBuilder->json(false, [], "Can't rollback history is current", ApiConstant::STATUS_BAD_REQUEST);
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $sessionIdOld = Yii::$app->request->post("data")["extras_data"]["session_id"] ?? null;
            $sessionWork->resetRollbackCurrent();
            $newSessionWork = SessionWorkForm::find()->where(["id" => $sessionIdOld])->one();
            if (!$newSessionWork) {
                $newSessionWork = new SessionWorkForm();
            }
            $newSessionWork->load(Yii::$app->request->post());
            if (!$newSessionWork->validate()) {
                $transaction->rollBack();
                return $this->responseBuilder->json(false, ["error" => $newSessionWork->getErrors()], "Error", ApiConstant::STATUS_BAD_REQUEST);
            }
            $newSessionWork->setAttributeByData();
            if (!$newSessionWork->save()) {
                $transaction->rollBack();
                return $this->responseBuilder->json(false, ["error" => $newSessionWork->getErrors()], "Error", ApiConstant::STATUS_BAD_REQUEST);
            }
            $sessionWork->is_session_current = SessionWorkAlias::IS_SESSION_CURRENT;
            if (!$sessionWork->save(false)) {
                $transaction->rollBack();
                return $this->responseBuilder->json(false, ["errors" => $sessionWork->getErrors()], "Error", ApiConstant::STATUS_BAD_REQUEST);
            }
            $transaction->commit();
            return $this->responseBuilder->json(true, [], "Success");
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return $this->responseBuilder->json(false, [], "Error", ApiConstant::STATUS_BAD_REQUEST);
        }
    }
}