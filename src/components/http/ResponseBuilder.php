<?php

namespace app\components\http;

use Yii;
use yii\base\BaseObject;
use yii\data\DataProviderInterface;
use yii\rest\Serializer;
use yii\web\HttpException;
use yii\web\Response;

class ResponseBuilder extends BaseObject
{
    /**
     * @param bool $status
     * @param $data
     * @param string $message
     * @param int $code
     * @return array
     */
    public function json(bool $status = true, $data = null, string $message = "", int $code = 200): array
    {
        Yii::$app->response->statusCode = $code;
        if ($data instanceof DataProviderInterface) {
            $serializer = new Serializer(['collectionEnvelope' => 'items']);
            $data = $serializer->serialize($data);
        }
        return [
            "status" => $status,
            "data" => $data,
            "messages" => $message,
            "code" => $code
        ];
    }

    public function raw($data)
    {
        Yii::$app->response->format = Response::FORMAT_RAW;
        return $data;
    }

    public function custom($data, $format)
    {
        Yii::$app->response->format = $format;
        return $data;
    }

    public function sendFile($path)
    {
        return Yii::$app->response->sendFile($path);
    }
}