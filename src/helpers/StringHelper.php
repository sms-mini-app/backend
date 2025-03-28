<?php

namespace app\helpers;

use yii\helpers\StringHelper as BaseStringHelper;

class StringHelper extends BaseStringHelper
{

    public static function slugVn($str)
    {
        return str_replace(
            array(
                'á', 'à', 'ả', 'ạ', 'ã', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ',
                'Á', 'À', 'Ả', 'Ạ', 'Ã', 'Ă', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ',
                'é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ',
                'É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ',
                'í', 'ì', 'ỉ', 'ĩ', 'ị',
                'Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị',
                'ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ',
                'Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ',
                'ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự',
                'Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự',
                'Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ',
                'ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ',
                'đ', 'Đ'
            ),
            array(
                'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
                'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A',
                'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
                'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E',
                'i', 'i', 'i', 'i', 'i',
                'I', 'I', 'I', 'I', 'I',
                'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
                'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O',
                'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
                'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U',
                'Y', 'Y', 'Y', 'Y', 'Y',
                'y', 'y', 'y', 'y', 'y',
                'd', 'D'
            ),
            $str
        );
    }

    public static function filterPhone($phone)
    {
        if (strlen($phone) < 10) {
            return "0" . $phone;
        }
        $cleanedCoutryCode = preg_replace('/^84/', '0', $phone);
        return $cleanedCoutryCode;
    }

    public static function compressString($str)
    {
        return base64_encode(gzcompress($str, 9));
    }

    public static function unCompressString($str): bool|string
    {
        return gzuncompress(base64_decode($str));
    }
}