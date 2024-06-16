<?php

namespace app\helpers;

use yii\base\BaseObject;

class Jwt extends BaseObject
{
    /**
     * @param string $data
     * @return array|string
     */
    protected function base64EncodeUrlSafe(string $data): array|string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    protected function base64Decode(string $data): bool|string
    {
        return base64_decode($data);
    }

    /**
     * @param array $header
     * @param array $payload
     * @param string $secretKey
     * @return string
     */
    public function createToken(array $header, array $payload,  string $secretKey): string
    {
        $headerEncode = $this->base64EncodeUrlSafe(json_encode($header));
        $payloadEncode = $this->base64EncodeUrlSafe(json_encode($payload));
        $signature = hash_hmac('sha256', $headerEncode . "." . $payloadEncode, $secretKey, true);
        $signatureEncode = $this->base64EncodeUrlSafe($signature);
        return $headerEncode . "." . $payloadEncode . "." . $signatureEncode;
    }

    /**
     * @param $token
     * @return array
     */
    public function getHeader($token): array
    {
        $header = explode(".", $token);
        $header = $header[0];
        return json_decode($this->base64Decode($header), true);
    }

    /**
     * @param $token
     * @return array
     */
    public function getPayload($token): array
    {
        $payload = explode(".", $token);
        $payload = $payload[1];
        return json_decode($this->base64Decode($payload), true);
    }

    /**
     * @param $token
     * @param $secretKey
     * @return bool
     */
    public function validate($token, $secretKey): bool
    {
        $header = $this->getHeader($token);
        $payload = $this->getPayload($token);
        $tokenVerify = $this->createToken($header, $payload, $secretKey);
        return $tokenVerify === $token;
    }
}
