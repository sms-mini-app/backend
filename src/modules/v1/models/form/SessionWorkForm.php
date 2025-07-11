<?php

namespace app\modules\v1\models\form;

use app\helpers\StringHelper;
use app\modules\v1\models\SessionWork;

class SessionWorkForm extends SessionWork
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            [["type", "data"], "required"],
            ["select_data", "safe"],
            ["type", "in", "range" => [self::TYPE_SMS, self::TYPE_CALL]],
            ["is_session_current", "default", "value" => self::NOT_IS_SESSION_CURRENT]
        ]); // TODO: Change the autogenerated stub
    }

    public function setAttributeByData()
    {
        switch ($this->type) {
            case self::TYPE_SMS:
                $this->filename = $this->data["extras_data"]["filename"];
                $this->report = $this->data["report_sms"];
        }
    }

    public function beforeSave($insert)
    {
        if ($this->isAttributeChanged("data")) {
            $this->data = StringHelper::compressString(json_encode($this->data));
        }
        if ($this->isAttributeChanged("select_data")) {
            $this->select_data = StringHelper::compressString(json_encode($this->select_data, JSON_FORCE_OBJECT));
        }
        parent::beforeSave($insert);
        return true;
    }

    public function setAllSessionNotUse(): void
    {
        SessionWork::updateAll(["is_session_current" => self::NOT_IS_SESSION_CURRENT], ["created_by" => $this->created_by]);
    }

    public function setSessionIsCurrent(): void
    {
        $this->is_session_current = true;
    }
}