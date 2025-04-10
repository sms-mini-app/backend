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
        $keyStorages["sms.font_black_list"] = '{"A":"𝐀","B":"𝐁","C":"𝐂","D":"𝐃","E":"𝐄","F":"𝐅","G":"𝐆","H":"𝐇","I":"𝐈","J":"𝐉","K":"𝐊","L":"𝐋","M":"𝐌","N":"𝐍","O":"𝐎","P":"𝐏","Q":"𝐐","R":"𝐑","S":"𝐒","T":"𝐓","U":"𝐔","V":"𝐕","W":"𝐖","X":"𝐗","Y":"𝐘","Z":"𝐙","a":"𝐚","b":"𝐛","c":"𝐜","d":"𝐝","e":"𝐞","f":"𝚏","g":"𝚐","h":"𝚑","i":"𝚒","j":"𝚓","k":"𝐤","l":"𝐥","m":"𝐦","n":"𝐧","o":"𝚘","p":"𝐩","q":"𝚚","r":"𝚛","s":"𝐬","t":"𝐭","u":"𝚞","v":"𝐯","w":"𝚠","x":"𝚡","y":"𝚢","z":"𝚣"}';
        return $this->responseBuilder->json(true, $keyStorages, "Success");
    }
}
