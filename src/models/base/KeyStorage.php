<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use \app\models\KeyStorageQuery;

/**
 * This is the base-model class for table "key_storage".
 *
 * @property string $key
 * @property string $value
 * @property string $comment
 * @property integer $updated_at
 * @property integer $created_at
 */
abstract class KeyStorage extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'key_storage';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['timestamp'] = [
            'class' => TimestampBehavior::class,
                        ];
        
    return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $parentRules = parent::rules();
        return ArrayHelper::merge($parentRules, [
            [['key', 'value'], 'required'],
            [['value', 'comment'], 'string'],
            [['key'], 'string', 'max' => 255],
            [['key'], 'unique']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'key' => 'Key',
            'value' => 'Value',
            'comment' => 'Comment',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ]);
    }

    /**
     * @inheritdoc
     * @return KeyStorageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KeyStorageQuery(static::class);
    }
}
