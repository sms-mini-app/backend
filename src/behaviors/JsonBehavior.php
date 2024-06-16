<?php

namespace app\behaviors;

use yii\db\ActiveRecord;
use yii\base\Behavior;

class JsonBehavior extends Behavior
{
    public $jsonAttributes;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => "encode",
            ActiveRecord::EVENT_AFTER_VALIDATE => "decode",
            ActiveRecord::EVENT_BEFORE_INSERT => "encode",
            ActiveRecord::EVENT_BEFORE_UPDATE => "encode",
            ActiveRecord::EVENT_AFTER_INSERT => "decode",
            ActiveRecord::EVENT_AFTER_UPDATE => "decode",
            ActiveRecord::EVENT_AFTER_FIND => "decode"
        ];
    }

    public function encode()
    {
        foreach ($this->jsonAttributes as $jsonAttribute) {
            $this->owner->$jsonAttribute = is_array($this->owner->$jsonAttribute)
                ? json_encode($this->owner->$jsonAttribute)
                : $this->owner->$jsonAttribute;
        }
    }

    public function decode()
    {
        foreach ($this->jsonAttributes as $jsonAttribute) {
            $this->owner->$jsonAttribute = is_string($this->owner->$jsonAttribute)
                ? json_decode($this->owner->$jsonAttribute, true)
                : $this->owner->$jsonAttribute;
        }
    }
}