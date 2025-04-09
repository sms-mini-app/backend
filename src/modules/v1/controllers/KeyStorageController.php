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
        $keyStorages["sms.font_black_list"] = '{"a":"𝙖","b":"𝙗","c":"𝙘","d":"𝙙","e":"𝙚","g":"𝙜","h":"𝙝","i":"𝙞","k":"𝙠","l":"𝙡","m":"𝙢","n":"𝙣","o":"𝙤","p":"𝙥","q":"𝙦","r":"𝙧","s":"𝙨","t":"𝙩","u":"𝙪","v":"𝙫","x":"𝙭","y":"𝙮","A":"𝘼","B":"𝘽","C":"𝘾","D":"𝘿","E":"𝙀","G":"𝙂","H":"𝙃","I":"𝙄","K":"𝙆","L":"𝙇","M":"𝙈","N":"𝙉","O":"𝙊","P":"𝙋","Q":"𝙌","R":"𝙍","S":"𝙎","T":"𝙏","U":"𝙐","V":"𝙑","X":"𝙓","Y":"𝙔"}';
        return $this->responseBuilder->json(true, $keyStorages, "Success");
    }
}
