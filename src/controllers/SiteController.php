<?php

namespace app\controllers;

use app\Test;
use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use function Sentry\captureException;

class SiteController extends Controller
{

    public function actionVersion()
    {
        return env("APP_VERSION") ? getenv("APP_VERSION") : "unknown";
    }

    public function actionError()
    {
        // Handling All Error Exception;
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $exception;
        }
    }

    public function actionAbc()
    {
        return (new Test())->run();
    }

    /**
     * Renders the start page.
     *
     * @return string
     */
    public function actionIndex()
    {
        return "Khương Nè";
    }

    public function actionStatus()
    {
        return "oke";
    }

    public function actionSentry()
    {
        try {
            throw new \Exception("Sentry Verify");
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
        }
    }

}
