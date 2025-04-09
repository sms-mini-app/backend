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
        $keyStorages["sms.font_black_list"] = '{"a":"𝚊","b":"𝚋","c":"𝚌","d":"𝚍","e":"𝚎","f":"𝐟","g":"𝚐","h":"𝚑","i":"𝚒","j":"𝚓","k":"𝐤","l":"𝚕","m":"𝚖","n":"𝚗","o":"𝚘","p":"𝐩","q":"𝚚","r":"𝚛","s":"𝐬","t":"𝚝","u":"𝚞","v":"𝚟","w":"𝚠","x":"𝚡","y":"𝐲","z":"𝚣","A":"𝐀","B":"𝐁","C":"𝚌","D":"𝐃","E":"𝚎","F":"𝐅","G":"𝐆","H":"𝚑","I":"𝐈","J":"𝐉","K":"𝚔","L":"𝐋","M":"𝐌","N":"𝚗","O":"𝐎","P":"𝚙","Q":"𝐐","R":"𝐑","S":"𝚜","T":"𝐓","U":"𝐔","V":"𝚟","W":"𝐖","X":"𝚡","Y":"𝐘","Z":"𝚣"}';
        return $this->responseBuilder->json(true, $keyStorages, "Success");
    }
}
