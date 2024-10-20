<?php

namespace app\modules\v1\models;

use app\models\App as BaseApp;

class App extends BaseApp
{
    public function fields()
    {
        return [
            "version",
            "version_level",
            "required_update",
            "description_upgrade",
            "link",
            "created_at"
        ];
    }
}
