<?php

namespace app\modules\v1\controllers;

use app\controllers\Controller;
use Yii;

class ErrorAppController extends Controller
{
    public function actionContact()
    {
        $this->redirect("https://zalo.me/0394182551");
    }


    public function actionLog()
    {
        $error = Yii::$app->request->post("error");
        if ($error) {
            $folder = Yii::getAlias("@webroot/logs/errors");
            if (is_dir($folder) === false) {
                mkdir($folder, 0777, true);
            }
            $filename = "$folder/" . date("Y_m_d") . ".log";
            $message = date("Y-m-d H:i:s") . " {$error}";
            file_put_contents($filename, $message . "\n", FILE_APPEND);
            return "stored";
        }
        return "no stored";
    }
}