<?php

namespace app\commands;

use app\components\web_portal\git_file_project\GitFileProjectComponent;
use app\components\web_portal\manager_file_project\ManagerFileComponent;
use Yii;
use yii\console\Controller;

class SiteController extends Controller
{

    public function actionTest()
    {
        /**
         * @var ManagerFileComponent $fileManager
         */
//        $fileManager = Yii::$app->web_portal->getService("manager_file_project");
//        var_dump($fileManager->getListPath("home/app.clould/dtsmart"));
        $gitFileProject = Yii::$app->web_portal->gitProject;
        $gitFileProject->prefix_path = "/projects/web-nails-23-005";
        $gitFileProject->addCommit("assets/style/_variables.scss");
    }

    public function actionIndex()
    {
        exec("cd home/app.clould/dtsmart && git ls-files", $output);
        print_r($output);
    }
}
