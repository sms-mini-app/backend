<?php

namespace app\components\keyStorage;

use Exception;
use Yii;
use yii\helpers\ArrayHelper;

class KeyStorageSingleton
{
    /**
     * @var string
     */
    public $cachePrefix = '_keyStorage';
    /**
     * @var int
     */
    public $cachingDuration = 60;
    /**
     * @var string
     */
    public $modelClass = '\app\models\KeyStorage';

    /**
     * @var array Runtime values cache
     */
    private $values = [];

    /**
     * @var KeyStorageSingleton $instance
     */
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public function set($key, $value)
    {
        $model = $this->getModel($key);
        if (!$model) {
            $model = new $this->modelClass;
            $model->key = $key;
            $model->created_at = time();
        }
        $model->updated_at = time();
        $model->value = $value;
        if ($model->save(false)) {
            $this->values[$key] = $value;
            Yii::$app->cache->set($this->getCacheKey($key), $value, $this->cachingDuration);
            return true;
        };
        return false;
    }

    /**
     * @param array $values
     */
    public function setAll(array $values)
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * @param $key
     * @param null $default
     * @param bool $cache
     * @param int|bool $cachingDuration
     * @return mixed|null
     * @throws Exception
     */
    public function get($key, $default = null, $cache = true, $cachingDuration = false)
    {
        if ($cache) {
            $cacheKey = $this->getCacheKey($key);
            $value = ArrayHelper::getValue($this->values, $key, false) ?: Yii::$app->cache->get($cacheKey);
            if ($value === false) {
                if ($model = $this->getModel($key)) {
                    $value = $model->value;
                    $this->values[$key] = $value;
                    Yii::$app->cache->set(
                        $cacheKey,
                        $value,
                        $cachingDuration === false ? $this->cachingDuration : $cachingDuration
                    );
                } else {
                    $value = $default;
                }
            }
        } else {
            $model = $this->getModel($key);
            $value = $model ? $model->value : $default;
        }
        return $value;
    }

    /**
     * @param array $keys
     * @return array
     */
    public function getAll(array $keys)
    {
        $values = [];
        foreach ($keys as $key) {
            $values[$key] = $this->get($key);
        }
        return $values;
    }

    /**
     * @param $key
     * @param bool $cache
     * @return bool
     */
    public function has($key, $cache = true)
    {
        return $this->get($key, null, $cache);
    }

    /**
     * @param array $keys
     * @return bool
     */
    public function hasAll(array $keys)
    {
        foreach ($keys as $key) {
            if (!$this->has($key)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $key
     * @return bool
     */
    public function remove($key)
    {
        unset($this->values[$key]);
        return call_user_func($this->modelClass . '::deleteAll', ['key' => $key]);
    }

    /**
     * @param array $keys
     */
    public function removeAll(array $keys)
    {
        foreach ($keys as $key) {
            $this->remove($key);
        }
    }

    /**
     * @param $key
     * @return mixed
     */
    protected function getModel($key)
    {
        $query = call_user_func($this->modelClass . '::find');
        return $query->where(['key' => $key])->one();
    }

    /**
     * @param $key
     * @return array
     */
    protected function getCacheKey($key)
    {
        return [
            __CLASS__,
            $this->cachePrefix,
            $key
        ];
    }
}